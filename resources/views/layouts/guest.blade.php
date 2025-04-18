<!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <title>E-Book Library</title>
   <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
   <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

   <style type="text/tailwindcss">
    body {
        background: linear-gradient(90deg, rgb(234, 234, 210) 0%, rgb(222, 184, 135) 100%);
        border: whitesmoke;
    }
   </style>
 </head>

 <body>
    <div class="container mx-auto mt-10 mb-10 ">
        @yield('content')
    </div>
 </body>

 </html>
