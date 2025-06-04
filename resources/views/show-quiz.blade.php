<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Categories</title>
    @vite(['resources/css/app.css'])

</head>
<body>
    <x-navbar name={{$name}} >   </x-navbar>
   
    <div class= "bg-gray-200 flex flex-col items-center p-5 min-h-screen">

    <h2 class="text-2xl text-center text-gray-800 mb-6">All Current Quiz MCQs 
        <a href="/add-quiz" class="text-yellow-500 text-md">Back</a> 
    </h2>
             

    {{-- Show category data table--}}
    <div class="w-200">
        <ul class="border border-gray-300">
            <li class="p-2 font-bold">
                    <ul class="flex justify-between">
                        <li class="w-30">MCQ ID</li>
                        <li class="w-170">Question</li>      
                    </ul>
                </li>

            @foreach($mcqs as $mcq)
                <li class="even:bg-gray-300 p-2">
                    <ul class="flex justify-between">
                        <li class="w-30">{{$mcq->id}}</li>
                        <li class="w-170"> {{$mcq->question}}</li>
                    </ul>
                </li>
            @endforeach
         </ul>
    </div>
     {{-- end category data table--}}

</div>
</body>
</html>


