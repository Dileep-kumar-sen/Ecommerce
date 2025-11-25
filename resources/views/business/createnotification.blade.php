@extends('business.sidebaar')
@section('title', 'Create Notification')
@section('content')

<div class="w-full max-w-3xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">



    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Notification Title -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" maxlength="60" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        </div>

        <!-- Notification Message -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Message <span class="text-red-500">*</span></label>
            <textarea name="message" rows="4" maxlength="250" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"></textarea>
        </div>

        <!-- Image / Banner (Optional) -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Image / Banner (Optional)</label>
            <div class="flex items-center justify-center w-full">
                <label
                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-300">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <img src="{{ asset('upload.png') }}" alt="Upload" width="110" height="110">
                        <p class="text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-400">PNG, JPG, GIF (max 5MB)</p>
                    </div>
                    <input type="file" name="image" class="hidden">
                </label>
            </div>
        </div>

        <!-- Target Audience -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Target Audience <span class="text-red-500">*</span></label>
            <select name="audience" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white">
                <option value="nearby">Nearby Users</option>
                <option value="all">All Users</option>

            </select>
        </div>

        <!-- Link / Offer Redirect -->


        <!-- Send Now / Schedule -->
         <div>
            <label class="block text-gray-700 font-medium mb-2">Schedule Time <span class="text-red-500">*</span></label>
            <input type="datetime-local" name="schedule_time" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        </div>

        <!-- Notification Type -->


        <!-- Priority / Urgency -->


        <!-- Send Button -->
        <div class="flex justify-center " style="margin-top: 20px;">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition transform hover:scale-105" style="background-color: #6B46C1;">
                Send Notification
            </button>
        </div>

    </form>
</div>

<!-- JS for Live Preview -->
<script>
    const titleInput = document.querySelector('input[name="title"]');
    const messageInput = document.querySelector('textarea[name="message"]');
    const previewTitle = document.getElementById('preview-title');
    const previewMessage = document.getElementById('preview-message');

    titleInput.addEventListener('input', () => {
        previewTitle.textContent = titleInput.value || "Notification Title";
    });
    messageInput.addEventListener('input', () => {
        previewMessage.textContent = messageInput.value || "Notification Message";
    });
</script>

@endsection
