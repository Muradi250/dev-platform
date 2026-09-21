<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Models\Page;
use App\Models\PageBlock;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;


    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    */

    protected function getHeaderActions(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | English Translation
            |--------------------------------------------------------------------------
            */

            $this->translationAction(
                'en',
                'English',
                '🇬🇧'
            ),


            /*
            |--------------------------------------------------------------------------
            | Persian Translation
            |--------------------------------------------------------------------------
            */

            $this->translationAction(
                'fa',
                'فارسی',
                '🇮🇷'
            ),


            /*
            |--------------------------------------------------------------------------
            | Pashto Translation
            |--------------------------------------------------------------------------
            */

            $this->translationAction(
                'ps',
                'پښتو',
                '🇦🇫'
            ),


            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
            */

            DeleteAction::make(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Translation Action
    |--------------------------------------------------------------------------
    |
    | اگر Translation موجود باشد:
    | مستقیماً وارد Edit آن می‌شود.
    |
    | اگر موجود نباشد:
    | Translation Group ساخته می‌شود و Page جدید ایجاد می‌شود.
    |
    */

    protected function translationAction(
        string $locale,
        string $label,
        string $flag
    ): Action {

        return Action::make('translation_' . $locale)

            ->label(function () use ($locale, $label, $flag) {

                $translation = $this->getRecord()
                    ->translation($locale);

                if ($translation) {
                    return $flag . ' Edit ' . $label;
                }

                return $flag . ' Create ' . $label . ' Translation';
            })

            ->action(function () use ($locale, $label) {

                /** @var Page $source */
                $source = $this->getRecord();


                /*
                |--------------------------------------------------------------------------
                | Check Existing Translation
                |--------------------------------------------------------------------------
                */

                $existingTranslation = $source
                    ->translation($locale);

                if ($existingTranslation) {

                    return redirect()->to(
                        PageResource::getUrl(
                            'edit',
                            [
                                'record' => $existingTranslation,
                            ]
                        )
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Create Translation Group
                |--------------------------------------------------------------------------
                */

                if (empty($source->translation_group)) {

                    $source->translation_group = (string) Str::uuid();

                    $source->save();
                }


                /*
                |--------------------------------------------------------------------------
                | Generate Translation Slug
                |--------------------------------------------------------------------------
                */

                $baseSlug = trim(
                    $source->slug . '-' . $locale,
                    '-'
                );

                $slug = $baseSlug;

                $counter = 2;

                while (
                    Page::query()
                        ->where('locale', $locale)
                        ->where('slug', $slug)
                        ->exists()
                ) {

                    $slug = $baseSlug . '-' . $counter;

                    $counter++;
                }


                /*
                |--------------------------------------------------------------------------
                | Create Translation Page
                |--------------------------------------------------------------------------
                */

                $translation = Page::create([

                    'title' => $source->title,

                    'slug' => $slug,

                    'status' => 'draft',

                    'locale' => $locale,

                    'seo_title' => null,

                    'seo_description' => null,

                    'settings' => $source->settings,

                    'created_by' => auth()->id(),

                    'published_at' => null,

                    'translation_group' => $source->translation_group,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Copy Page Blocks
                |--------------------------------------------------------------------------
                |
                | تمام Blockهای Page اصلی برای Translation جدید
                | کپی می‌شوند.
                |
                | محتوا فعلاً ترجمه نمی‌شود و همان داده اصلی
                | کپی می‌شود تا بعداً در زبان مقصد ویرایش شود.
                |
                */

                $source->blocks()
                    ->get()
                    ->each(function (PageBlock $block) use ($translation) {

                        PageBlock::create([

                            'page_id' => $translation->id,

                            'type' => $block->type,

                            'data' => $block->data,

                            'settings' => $block->settings,

                            'sort_order' => $block->sort_order,

                            'is_active' => $block->is_active,

                        ]);

                    });


                /*
                |--------------------------------------------------------------------------
                | Notification
                |--------------------------------------------------------------------------
                */

                Notification::make()

                    ->title('Translation Created')

                    ->body(
                        'The ' . $label . ' translation has been created as a draft with copied blocks.'
                    )

                    ->success()

                    ->send();


                /*
                |--------------------------------------------------------------------------
                | Open Translation
                |--------------------------------------------------------------------------
                */

                return redirect()->to(

                    PageResource::getUrl(
                        'edit',
                        [
                            'record' => $translation,
                        ]
                    )

                );
            });
    }
}
