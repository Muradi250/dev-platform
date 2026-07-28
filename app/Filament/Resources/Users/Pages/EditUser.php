<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Facades\Auth;


class EditUser extends EditRecord
{


    /*
    |--------------------------------------------------------------------------
    | Resource
    |--------------------------------------------------------------------------
    */

    protected static string $resource = UserResource::class;






    /*
    |--------------------------------------------------------------------------
    | Authorize Access
    |--------------------------------------------------------------------------
    |
    | محافظت System Owner
    |
    | قوانین:
    |
    | - هیچکس نمی‌تواند Owner را ویرایش کند
    |   مگر خود Owner
    |
    */

    protected function authorizeAccess(): void
    {

        parent::authorizeAccess();


        $record = $this->getRecord();



        if (

            $record->is_owner

            &&

            Auth::id() !== $record->id

        ) {


            abort(
                403,
                'System Owner account is protected.'
            );


        }


    }







    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    |
    | Owner Delete نمی‌شود
    |
    */

    protected function getHeaderActions(): array
    {


        if (

            $this->getRecord()->is_owner

        ) {


            return [];


        }




        return [

            DeleteAction::make()

                ->requiresConfirmation()

                ->modalHeading(
                    'Delete User Account'
                )

                ->modalDescription(
                    'This action cannot be undone.'

                ),

        ];


    }







    /*
    |--------------------------------------------------------------------------
    | Before Save
    |--------------------------------------------------------------------------
    |
    | جلوگیری از تغییر Owner
    |
    */

    protected function mutateFormDataBeforeSave(array $data): array
    {


        $record = $this->getRecord();



        /*
        | Owner همیشه Owner می‌ماند
        */


        if ($record->is_owner) {


            $data['is_owner'] = true;


        }




        /*
        | Owner همیشه Super Admin باقی می‌ماند
        |
        | Role در فرم جدا محافظت می‌شود
        |
        */



        return $data;


    }



}