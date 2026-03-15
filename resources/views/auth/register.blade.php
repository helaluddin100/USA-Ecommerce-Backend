<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - B2B Ecommerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Join Us</h1>
                <p class="mt-2 text-gray-600">
                    To complete the sign-up process, please respond to our email sent by our sales team.
                </p>
                <p class="mt-1 text-sm text-gray-500">
                    It can take up to 5 working days for our sales team to send you the email.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="bg-white shadow-lg rounded-lg p-8">
                @csrf

                <!-- Company Information Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Information <span class="text-red-500">*</span> mandatory</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Company name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="company_name" id="company_name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('company_name') }}">
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                Country <span class="text-red-500">*</span>
                            </label>
                            <select name="country" id="country" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Choose country</option>
                                @include('partials.countries')
                            </select>
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span> <span class="text-gray-500 text-xs">(Please enter a valid email)</span>
                            </label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Website URL
                            </label>
                            <input type="url" name="website_url" id="website_url"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('website_url') }}">
                            @error('website_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone_no" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone No. <span class="text-gray-500 text-xs">(Including country code)</span>
                            </label>
                            <input type="text" name="phone_no" id="phone_no"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('phone_no') }}">
                            @error('phone_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fax_no" class="block text-sm font-medium text-gray-700 mb-2">
                                Fax No.
                            </label>
                            <input type="text" name="fax_no" id="fax_no"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('fax_no') }}">
                            @error('fax_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address
                            </label>
                            <textarea name="address" id="address" rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                City <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="city" id="city" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('city') }}">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                                State <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="state" id="state" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('state') }}">
                            @error('state')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-2">
                                Zip <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="zip" id="zip" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('zip') }}">
                            @error('zip')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="contact_name" id="contact_name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('contact_name') }}">
                            @error('contact_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                Position
                            </label>
                            <input type="text" name="position" id="position"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('position') }}">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Authentication Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span> <span class="text-gray-500 text-xs">(Minimum of 5 characters)</span>
                            </label>
                            <input type="text" name="username" id="username" required minlength="5"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('username') }}">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Business Information Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Business Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type_of_business" class="block text-sm font-medium text-gray-700 mb-2">
                                Type of Business <span class="text-red-500">*</span>
                            </label>
                            <select name="type_of_business" id="type_of_business" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select business type</option>
                                <option value="retailer" {{ old('type_of_business') == 'retailer' ? 'selected' : '' }}>Retailer</option>
                                <option value="wholesaler" {{ old('type_of_business') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                <option value="online_shop" {{ old('type_of_business') == 'online_shop' ? 'selected' : '' }}>On-line shop</option>
                                <option value="offline_shop" {{ old('type_of_business') == 'offline_shop' ? 'selected' : '' }}>Off-line shop</option>
                                <option value="network_sales" {{ old('type_of_business') == 'network_sales' ? 'selected' : '' }}>Network sales</option>
                                <option value="sns_sales" {{ old('type_of_business') == 'sns_sales' ? 'selected' : '' }}>SNS sales</option>
                            </select>
                            @error('type_of_business')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="registration_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Registration path <span class="text-red-500">*</span>
                            </label>
                            <select name="registration_path" id="registration_path" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Path selection</option>
                                <option value="stylekorean" {{ old('registration_path') == 'stylekorean' ? 'selected' : '' }}>StyleKorean</option>
                                <option value="google" {{ old('registration_path') == 'google' ? 'selected' : '' }}>Google</option>
                                <option value="instagram_facebook" {{ old('registration_path') == 'instagram_facebook' ? 'selected' : '' }}>Instagram / Facebook</option>
                                <option value="tiktok" {{ old('registration_path') == 'tiktok' ? 'selected' : '' }}>Tiktok</option>
                                <option value="recommendation" {{ old('registration_path') == 'recommendation' ? 'selected' : '' }}>Recommendation</option>
                                <option value="others" {{ old('registration_path') == 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('registration_path')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Interesting Business <span class="text-gray-500 text-xs">(Duplicate check is available)</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="interesting_business[]" value="kpop"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        {{ in_array('kpop', old('interesting_business', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">Kpop</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="interesting_business[]" value="kbeauty"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        {{ in_array('kbeauty', old('interesting_business', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">Kbeauty</span>
                                </label>
                            </div>
                            @error('interesting_business')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="introduce" class="block text-sm font-medium text-gray-700 mb-2">
                                Introduce
                            </label>
                            <textarea name="introduce" id="introduce" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('introduce') }}</textarea>
                            @error('introduce')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- NDA Agreement Section -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">NON-DISCLOSURE AGREEMENT <span class="text-red-500">*</span> mandatory</h2>
                    
                    <div class="text-sm text-gray-700 space-y-3 mb-4">
                        <p>
                            This site, and any contents or web pages attached, contains confidential and proprietary information that is intended for the exclusive use of SILICON2 CO., LTD., employees and authorized partners for the limited purpose of submitting orders and/or viewing products for wholesale customers.
                        </p>
                        <p>
                            Only authorized employees and partners are permitted to access this system and any unauthorized use of this system is unlawful. The information and material contained on this site is confidential, and all authorized persons accessing the material have an obligation of confidentiality.
                        </p>
                        <p>
                            If you are not an authorized employee or partner of SILICON2 CO., LTD., you are hereby notified that any entry into this site or disclosure, copying, distribution or use of any of the information contained in or attached to this site is strictly prohibited.
                        </p>
                        <p>
                            If you are uncertain of your authorization status, please contact us via email at: <a href="mailto:wholesale@stylekoreanus.com" class="text-blue-600 hover:underline">wholesale@stylekoreanus.com</a>
                        </p>
                    </div>

                    <label class="flex items-start">
                        <input type="checkbox" name="nda_agreement" value="1" required
                            class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ old('nda_agreement') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium text-gray-900">I agree</span>
                    </label>
                    @error('nda_agreement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Continue to register
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Copyright ⓒ StyleKorean.com All Rights Reserved.</p>
                <p class="mt-1">
                    <a href="mailto:wholesale@stylekoreanus.com" class="text-blue-600 hover:underline">wholesale@stylekoreanus.com</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

