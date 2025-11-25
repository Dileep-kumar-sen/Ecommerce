@extends('business.sidebaar')

@section('content')
@section('title', 'Help And Support')
<div class="flex-1 p-2 sm:p-6 flex flex-col h-screen">
   <!-- Header -->
   <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
      <div class="flex items-center space-x-4">
         <div class="relative">
            <span class="absolute text-green-500 right-0 bottom-0">
               <svg width="20" height="20"><circle cx="8" cy="8" r="8" fill="currentColor"></circle></svg>
            </span>
            <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=3&w=144&h=144" alt="" class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
         </div>
         <div class="flex flex-col leading-tight">
            <div class="text-2xl mt-1 flex items-center">
               <span class="text-gray-700 mr-3">Anderson Vanhron</span>
            </div>
            <span class="text-lg text-gray-600">Admin</span>
         </div>
      </div>
   </div>

   <!-- Messages -->
   <div id="messages" class="flex-1 overflow-y-auto p-3 space-y-4 scrollbar-thin scrollbar-thumb-rounded scrollbar-thumb-gray-400">

      <!-- Incoming Message -->
      <div class="flex items-start space-x-3">
         <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=3&w=144&h=144" alt="Sender" class="w-8 h-8 rounded-full mt-1">
         <div class="bg-gray-200 text-gray-800 p-3 rounded-lg rounded-bl-none shadow max-w-xs">
            Can be verified on any platform using docker
            <span class="text-xs text-gray-500 block mt-1">10:12 AM</span>
         </div>
      </div>

      <!-- Outgoing Message -->
      <div class="flex items-end justify-end space-x-3 space-x-reverse">
         <div class="bg-blue-600 text-white p-3 rounded-lg rounded-br-none shadow max-w-xs text-right">
            Your error message says permission denied, npm global installs must be given root privileges.
            <span class="text-xs text-gray-200 block mt-1">10:14 AM</span>
         </div>
         <img src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=3&w=144&h=144" alt="You" class="w-8 h-8 rounded-full mt-1">
      </div>

      <!-- Multiple lines incoming -->
      <div class="flex items-start space-x-3">
         <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=3&w=144&h=144" alt="Sender" class="w-8 h-8 rounded-full mt-1">
         <div class="bg-gray-200 text-gray-800 p-3 rounded-lg shadow max-w-xs space-y-1">
            <div>Command was run with root privileges. I'm sure about that.</div>
            <div>I've updated the description so it's more obvious now.</div>
            <div>FYI <a href="https://askubuntu.com/a/700266/510172" class="text-blue-600 underline">https://askubuntu.com/a/700266/510172</a></div>
            <span class="text-xs text-gray-500 block mt-1">10:16 AM</span>
         </div>
      </div>

      <!-- Multiple lines outgoing -->
      <div class="flex items-end justify-end space-x-3 space-x-reverse">
         <div class="bg-blue-600 text-white p-3 rounded-lg rounded-br-none shadow max-w-xs space-y-1 text-right">
            <div>Any updates on this issue? I'm getting the same error when trying to install devtools. Thanks</div>
            <span class="text-xs text-gray-200 block mt-1">10:18 AM</span>
         </div>
         <img src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=3&w=144&h=144" alt="You" class="w-8 h-8 rounded-full mt-1">
      </div>

      <!-- Repeat pattern for other messages -->
   </div>

   <!-- Input Box -->
   <div class="border-t-2 border-gray-200 px-4 py-4">
    <div class="relative flex items-center">
        <!-- Input Box -->
        <input type="text" id="chat-input" placeholder="Enter your message"
               class="w-full pr-24 pl-4 py-3 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400" />

        <!-- Send Button -->
        <button id="send-btn"
                class="absolute right-0 bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-lg">
            Send
        </button>
    </div>
</div>
</div>

<script>
	const el = document.getElementById('messages');
	el.scrollTop = el.scrollHeight;
</script>
<script>
const inputEl = document.getElementById('chat-input');
const sendBtn = document.getElementById('send-btn');

sendBtn.addEventListener('click', () => {
    if(inputEl.value.trim() !== "") {
        alert("Message: " + inputEl.value); // yahan pe tum chat add kar sakte ho
        inputEl.value = '';
        inputEl.focus();
    }
});

// Send on Enter key
inputEl.addEventListener('keypress', (e) => {
    if(e.key === 'Enter') sendBtn.click();
});
</script>
@endsection

