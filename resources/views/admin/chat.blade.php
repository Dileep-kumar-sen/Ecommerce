@extends('admin.sidebaar')
@section('title', 'Help And Support')
@section('content')


<div class="flex h-screen">
  <!-- Sidebar -->
  <div class="w-1/4 bg-white border-r border-gray-300 flex flex-col">
    <!-- Sidebar Header -->
    <header class="p-4 border-b border-gray-300 flex justify-between items-center bg-indigo-600 text-white">
      <h1 class="text-2xl font-semibold" style="color:black">Business User</h1>
    </header>

    <!-- Contact List -->
    <div class="flex-1 overflow-y-auto p-3">
      <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
        <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
          <img src="https://placehold.co/200x/ffa8e4/ffffff.svg" class="w-12 h-12 rounded-full">
        </div>
        <div>
          <h2 class="text-lg font-semibold">Alice</h2>
          <p class="text-gray-600">Hoorayy!!</p>
        </div>
      </div>
          <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
              <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                <img src="https://placehold.co/200x/ad922e/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
              </div>
              <div class="flex-1">
                <h2 class="text-lg font-semibold">Martin</h2>
                <p class="text-gray-600">That pizza place was amazing! We should go again sometime. 🍕</p>
              </div>
            </div>

            <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
              <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                <img src="https://placehold.co/200x/2e83ad/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
              </div>
              <div class="flex-1">
                <h2 class="text-lg font-semibold">Charlie</h2>
                <p class="text-gray-600">Hey, do you have any recommendations for a good movie to watch?</p>
              </div>
            </div>

            <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
              <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                <img src="https://placehold.co/200x/c2ebff/0f0b14.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
              </div>
              <div class="flex-1">
                <h2 class="text-lg font-semibold">David</h2>
                <p class="text-gray-600">I just finished reading a great book! It was so captivating.</p>
              </div>
            </div>

            <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
              <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                <img src="https://placehold.co/200x/e7c2ff/7315d1.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
              </div>
              <div class="flex-1">
                <h2 class="text-lg font-semibold">Ella</h2>
                <p class="text-gray-600">What's the plan for this weekend? Anything fun?</p>
              </div>
            </div>

            <div class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
              <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                <img src="https://placehold.co/200x/ffc2e2/ffdbdb.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
              </div>
              <div class="flex-1">
                <h2 class="text-lg font-semibold">Fiona</h2>
                <p class="text-gray-600">I heard there's a new exhibit at the art museum. Interested?</p>
              </div>
            </div>
      <!-- aur contacts yaha add kar lo -->
    </div>
  </div>

  <!-- Main Chat Area -->
  <div class="flex flex-col flex-1">
    <!-- Chat Header -->
    <header class="bg-white p-4 text-gray-700 border-b">
      <h1 class="text-2xl font-semibold">Alice</h1>
    </header>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
      <!-- Incoming Message -->
      <div class="flex">
        <img src="https://placehold.co/200x/ffa8e4/ffffff.svg" class="w-8 h-8 rounded-full mr-2">
        <div class="bg-white p-3 rounded-lg shadow text-gray-700">
          Hey Bob, how's it going?
        </div>
      </div>

      <!-- Outgoing Message -->
      <div class="flex justify-end">
        <div class="bg-indigo-500 text-white p-3 rounded-lg shadow" style="color: black">
          Hi Alice! I'm good, just finished a great book.
        </div>
        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg" class="w-8 h-8 rounded-full ml-2">
      </div>
      <div class="flex justify-end">
        <div class="bg-indigo-500 text-white p-3 rounded-lg shadow" style="color: black">
          Hi Alice! I'm good, just finished a great book.
        </div>
        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg" class="w-8 h-8 rounded-full ml-2">
      </div>
      <div class="flex justify-end">
        <div class="bg-indigo-500 text-white p-3 rounded-lg shadow" style="color: black">
          Hi Alice! I'm good, just finished a great book.
        </div>
        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg" class="w-8 h-8 rounded-full ml-2">
      </div>
      <div class="flex justify-end">
        <div class="bg-indigo-500 text-white p-3 rounded-lg shadow" style="color: black">
          Hi Alice! I'm good, just finished a great book.
        </div>
        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg" class="w-8 h-8 rounded-full ml-2">
      </div>
      <div class="flex justify-end">
        <div class="bg-indigo-500 text-white p-3 rounded-lg shadow" style="color: black">
          Hi Alice! I'm good, just finished a great book.
        </div>
        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg" class="w-8 h-8 rounded-full ml-2">
      </div>
      <div class="flex justify-end">
        <div class="bg-indigo-500 text-white p-3 rounded-lg shadow" style="color: black">
          Hi Alice! I'm good, just finished a great book.
        </div>
        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg" class="w-8 h-8 rounded-full ml-2">
      </div>
    </div>

    <!-- Chat Input -->
    <footer class="bg-white border-t border-gray-300 p-4">
      <div class="flex items-center">
        <input type="text" placeholder="Type a message..."
               class="w-full p-2 rounded-md border border-gray-400 focus:outline-none focus:border-indigo-500">
        <button class="bg-indigo-500 text-white px-4 py-2 rounded-md ml-2" style="background: blue">Send</button>
      </div>
    </footer>
  </div>
</div>


@endsection
