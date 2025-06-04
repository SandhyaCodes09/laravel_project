<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Quiz page</title>
    @vite(['resources/css/app.css'])

</head>
<body>
    <x-navbar name={{$name}} >   </x-navbar>

    <div class= "bg-gray-200 flex flex-col items-center p-5 min-h-screen">

        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            @if(!session('quizDetails'))
                <h2 class="text-2xl text-center text-gray-800 mb-6">Admin Quiz</h2>
                @error('user')
                    <div class = "text-red-500">{{$message}}</div>
                @enderror
                <form  action="/add-quiz" method="get" class="space-y-4">
                    {{-- @csrf --}}
                    <div>
                        <input type="text" placeholder="Enter quiz Name" name="quiz" required
                        class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                        
                    </div>

                    <div>
                        <select type="text" placeholder="Enter quiz Name" name="category_id"
                        class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                        
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    

                    <button type="submit" class="w-full bg-blue-500 rounded-xl px-4 py-2 text-white">Add</button>
                </form>
                @else
                <span class="text-green-500 font-bold">Quiz : {{ session('quizDetails')->name }}</span>
                <p class="text-green-500 font-bold">Total MCQs : {{ $totalMCQs }}
                    @if($totalMCQs>0)
                        <a class="text-yellow-500 text-sm" href="show-quiz/{{session('quizDetails')->id }}">Show MCQs</a>
                    @endif
                </p>
                <h2 class="text-2xl text-center text-gray-800 mb-6">Add MCQ's</h2>

                <form action="add-mcq" method="post" class="space-y-4">
                  @csrf

                        <div>
                            <textarea type="text" placeholder="Enter Your Question" name="question"
                            class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none"></textarea>
                            @error('question')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <input type="text" placeholder="Enter first option" name="a"
                            class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                            @error('a')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <input type="text" placeholder="Enter second option" name="b"
                            class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                            @error('b')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <input type="text" placeholder="Enter third option" name="c"
                            class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                            @error('c')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <input type="text" placeholder="Enter fourth option" name="d"
                            class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                            @error('d')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <select name="correct_ans"
                            class="w-full px-4 py-2 border border-gray-500 rounded-xl focus-outline-none">
                            <option value="">select right answer</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>                      
                            </select>
                            @error('correct_ans')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                  <button type="submit" name="submit" value="add-more" class="w-full bg-blue-500 rounded-xl px-4 py-2 text-white">Add More</button>
                 <button type="submit" name="submit" value="done"class="w-full bg-green-500 rounded-xl px-4 py-2 text-white">Add and Submit</button>
                 <a class="w-full bg-red-500 block text-center rounded-xl px-4 py-2 text-white" href="/end-quiz">Finish Quiz</a>


                </form>
                
              @endif
                
        </div>
    </div>

       
</body>    