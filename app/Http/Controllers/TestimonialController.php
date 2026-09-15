<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Display the testimonial submission form.
     */
    public function create(): View
    {
        return view('public.testimonials.submit');
    }

    /**
     * Store a new testimonial submission.
     */
    public function store(
        StoreTestimonialRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request
                ->file('avatar')
                ->store('testimonials', 'public');
        }

        $validated['status'] = 'pending';
        $validated['featured'] = false;
        $validated['approved_at'] = null;

        Testimonial::create($validated);

        return back()->with(
            'testimonial_success',
            'Thank you! Your testimonial has been submitted and is awaiting approval.'
        );
    }
}