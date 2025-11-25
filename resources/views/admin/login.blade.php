<!doctype html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-100 via-white to-blue-50 flex items-center justify-center">
<div class="max-w-lg w-full bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
<div class="p-8 sm:p-10">
<div class="flex items-center gap-4 mb-6">
<div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xl font-bold">A</div>
<div>
<h1 class="text-2xl font-semibold text-gray-800">Welcome back, Admin</h1>
<p class="text-sm text-gray-500">Sign in to manage the dashboard</p>
</div>
</div>


@if($errors->any())
<div class="mb-4 text-sm text-red-600">{{ $errors->first() }}</div>
@endif


<form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
@csrf


<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
<input name="email" value="{{ old('email') }}" type="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="admin@example.com">
</div>


<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
<input name="password" type="password" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Your password">
</div>


<div class="flex items-center justify-between text-sm">
<label class="flex items-center gap-2">
<input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300">
<span class="text-gray-600">Remember me</span>
</label>
<a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
</div>


<div>
<button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-md hover:opacity-95">Sign in</button>
</div>
</form>


<p class="text-center text-xs text-gray-400 mt-6">Last login: <span id="time">--</span></p>
</div>
</div>


<script>
// small flourish: show local time
document.getElementById('time').innerText = new Date().toLocaleString();
</script>
</body>
</html>
