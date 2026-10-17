<?php

namespace Tests\Feature;

use App\Filament\Resources\Permissions\PermissionResource;
use App\Filament\Resources\Roles\RoleResource;
use App\Filament\Resources\Testimonials\TestimonialResource;
use Filament\Support\Icons\Heroicon;
use Tests\TestCase;

class ResourceNavigationIconsTest extends TestCase
{
    public function test_roles_permissions_and_testimonials_have_distinct_icons(): void
    {
        $this->assertSame(Heroicon::OutlinedUserGroup, RoleResource::getNavigationIcon());
        $this->assertSame(Heroicon::OutlinedKey, PermissionResource::getNavigationIcon());
        $this->assertSame(Heroicon::OutlinedChatBubbleLeftRight, TestimonialResource::getNavigationIcon());
    }
}
