<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'د :attribute ساحہ قبول کړئ.',
    'accepted_if' => 'د :attribute ساحہ باید قبول شوې وي کله :other :value وي.',
    'active_url' => 'د :attribute ساحہ باید معتبر URL وي.',
    'after' => 'د :attribute ساحہ باید :date څخه وروسته نیټې وي.',
    'after_or_equal' => 'د :attribute ساحہ باید :date څخه وروسته یا برابر نیټې وي.',
    'alpha' => 'د :attribute ساحہ باید یوازې حروف ولري.',
    'alpha_dash' => 'د :attribute ساحہ باید یوازې حروف، شمیر، ڈیش او انڈرسکور ولري.',
    'alpha_num' => 'د :attribute ساحہ باید یوازې حروف او شمیر ولري.',
    'array' => 'د :attribute ساحہ باید صف وي.',
    'before' => 'د :attribute ساحہ باید :date سے مخکې نیټې وي.',
    'before_or_equal' => 'د :attribute ساحہ باید :date سے مخکې یا برابر نیټې وي.',
    'between' => [
        'array' => 'د :attribute ساحہ باید :min او :max موارد لري.',
        'file' => 'د :attribute ساحہ باید :min او :max کیلوبائٹس ترمنځ وي.',
        'numeric' => 'د :attribute ساحہ باید :min او :max ترمنځ وي.',
        'string' => 'د :attribute ساحہ باید :min او :max کردار ترمنځ وي.',
    ],
    'boolean' => 'د :attribute ساحہ باید true یا false وي.',
    'confirmed' => 'd :attribute ساحہ تایید مطابقت نه لري.',
    'current_password' => 'د رمز غلط دی.',
    'date' => 'د :attribute ساحہ باید معتبر نیټې وي.',
    'date_equals' => 'د :attribute ساحہ باید :date سره برابر نیټې وي.',
    'date_format' => 'd :attribute ساحہ باید :format ،سره مطابقت ولري.',
    'declined' => 'د :attribute ساحہ باید ردشوې وي.',
    'declined_if' => 'د :attribute ساحہ باید ردشوې وي کله :other :value وي.',
    'different' => 'د :attribute ساحہ او :other متفاوت وي.',
    'digits' => 'د :attribute ساحہ باید :digits ارقام وي.',
    'digits_between' => 'د :attribute ساحہ باید :min او :max ارقام ترمنځ وي.',
    'email' => 'د :attribute ساحہ باید معتبر ای میل وي.',
    'exists' => 'د :attribute انتخاب شوی غلط دی.',
    'file' => 'د :attribute ساحہ باید فائل وي.',
    'filled' => 'د :attribute ساحہ باید قدر ولري.',
    'gt' => [
        'array' => 'د :attribute ساحہ باید :value څخه ډیر موارد ولري.',
        'file' => 'د :attribute ساحہ باید :value کیلوبائٹس څخه لویې وي.',
        'numeric' => 'د :attribute ساحہ باید :value څخه لویې وي.',
        'string' => 'د :attribute ساحہ باید :value کردار څخه ډیر وي.',
    ],
    'gte' => [
        'array' => 'د :attribute ساحہ باید :value موارد یا ډیر ولري.',
        'file' => 'د :attribute ساحہ باید :value کیلوبائٹس سے لویې یا برابر وي.',
        'numeric' => 'د :attribute ساحہ باید :value سے لویې یا برابر وي.',
        'string' => 'د :attribute ساحہ باید :value کردار سے لویې یا برابر وي.',
    ],
    'image' => 'د :attribute ساحہ باید عکس وي.',
    'in' => 'د :attribute انتخاب شوی غلط دی.',
    'in_array' => 'd :attribute ساحہ :other کې موجود وي.',
    'integer' => 'د :attribute ساحہ باید عدد صحیح وي.',
    'ip' => 'د :attribute ساحہ باید معتبر IP پتہ وي.',
    'ipv4' => 'د :attribute ساحہ باید معتبر IPv4 پتہ وي.',
    'ipv6' => 'د :attribute ساحہ باید معتبر IPv6 پتہ وي.',
    'json' => 'د :attribute ساحہ باید معتبر JSON string وي.',
    'lt' => [
        'array' => 'د :attribute ساحہ باید :value کم موارد ولري.',
        'file' => 'د :attribute ساحہ باید :value کیلوبائٹس کم وي.',
        'numeric' => 'د :attribute ساحہ باید :value کم وي.',
        'string' => 'د :attribute ساحہ باید :value کردار کم وي.',
    ],
    'lte' => [
        'array' => 'د :attribute ساحہ نباید :value څخه ډیر موارد ولري.',
        'file' => 'د :attribute ساحہ باید :value کیلوبائٹس سے کم یا برابر وي.',
        'numeric' => 'د :attribute ساحہ باید :value سے کم یا برابر وي.',
        'string' => 'د :attribute ساحہ باید :value کردار سے کم یا برابر وي.',
    ],
    'max' => [
        'array' => 'د :attribute ساحہ نباید :max څخه ډیر موارد ولري.',
        'file' => 'د :attribute ساحہ نباید :max کیلوبائٹس سے لویې وي.',
        'numeric' => 'د :attribute ساحہ نباید :max سے لویې وي.',
        'string' => 'د :attribute ساحہ نباید :max کردار سے ډیر وي.',
    ],
    'mimes' => 'د :attribute ساحہ باید د نوع فائل وي: :values.',
    'mimetypes' => 'د :attribute ساحہ باید د نوع فائل وي: :values.',
    'min' => [
        'array' => 'د :attribute ساحہ باید حد اقل :min موارد ولري.',
        'file' => 'د :attribute ساحہ باید حد اقل :min کیلوبائٹس وي.',
        'numeric' => 'د :attribute ساحہ باید حد اقل :min وي.',
        'string' => 'د :attribute ساحہ باید حد اقل :min کردار وي.',
    ],
    'not_in' => 'د :attribute انتخاب شوی غلط دی.',
    'numeric' => 'د :attribute ساحہ باید شمیر وي.',
    'password' => 'رمز غلط دی.',
    'present' => 'د :attribute ساحہ باید موجود وي.',
    'regex' => 'd :attribute ساحہ فارمیٹ غلط دی.',
    'required' => 'd :attribute ساحہ ضروری دی.',
    'required_if' => 'd :attribute ساحہ ضروری دی کله :other :value وي.',
    'required_unless' => 'd :attribute ساحہ ضروری دی مگر :other :values کې وي.',
    'required_with' => 'd :attribute ساحہ ضروری دی کله :values موجود دی.',
    'required_with_all' => 'd :attribute ساحہ ضروری دی کله :values موجود دی.',
    'required_without' => 'd :attribute ساحہ ضروری دی کله :values موجود نه دی.',
    'required_without_all' => 'd :attribute ساحہ ضروری دی کله :values کوم هم موجود نه دی.',
    'same' => 'd :attribute ساحہ :other سره مطابقت ولري.',
    'size' => [
        'array' => 'd :attribute ساحہ :size موارد ولري.',
        'file' => 'd :attribute ساحہ :size کیلوبائٹس وي.',
        'numeric' => 'd :attribute ساحہ :size وي.',
        'string' => 'd :attribute ساحہ :size کردار وي.',
    ],
    'starts_with' => 'd :attribute ساحہ باید د لاندې څخه یو سره شروع شوي وي: :values.',
    'string' => 'd :attribute ساحہ باید string وي.',
    'timezone' => 'd :attribute ساحہ باید معتبر timezone وي.',
    'unique' => 'd :attribute ساحہ پهلو سې اخستل شوي دي.',
    'uploaded' => 'd :attribute ساحہ بارګذاري شوه.',
    'url' => 'd :attribute ساحہ باید معتبر URL وي.',
    'uuid' => 'd :attribute ساحہ باید معتبر UUID وي.',

    'attributes' => [
        'name' => 'نام',
        'email' => 'ای میل',
        'password' => 'پاسورډ',
        'password_confirmation' => 'پاسورډ تصدیق کړئ',
    ],

];
