<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>

    <body class="min-h-screen w-full bg-[#191919]">
        <header class="h-[200px] w-full bg-[#0D0D0D]">
            <div class="text-[#5E60CE] font-bold text-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
            <div class="flex place-content-center h-full">
                <div class="flex items-center gap-3">
                    <div>
                        <img src="{{ asset('images/rocket.svg') }}" alt="Logo">
                    </div>
                    <div> 
                        <span class="text-[#4EA8DE] text-4xl font-bold">to</span><span class="text-[#5E60CE] text-4xl font-[900]">do</span>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="flex gap-8 -mt-10 justify-center">
                <form action="{{ url('/tasks') }}" method="POST">
                    <input class="w-[880px] h-[50px] p-5 text-sm border-none rounded-sm my-5 bg-[#262626] text-white focus:outline-none focus:ring-2 focus:ring-[#5E60CE]" required maxlength="105" type="text" name="task" placeholder="Digite sua tarefa">
                    <button class="h-[50px] p-2 text-sm border-none rounded my-5 bg-[#1E6F9F] text-white" type="submit">Adicionar <i class="fa-solid fa-plus fa-sm"></i></button>
                    @csrf 
                </form>
            </div>

            <section class="w-[965px] mx-auto mt-10">
                <div class="flex justify-between items-center w-full">
                    <div class="flex gap-2">
                        <span id="created-tasks" class="text-[#4EA8DE] font-bold">Tarefas criadas</span>
                        <span class="text-white font-bold text-sm bg-[#262626] py-0.5 px-2 rounded-[15px]">{{ $totalTasks }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-[#5E60CE] font-bold">Concluídas</span>
                        <span class="text-white font-bold text-sm bg-[#262626] py-0.5 px-2 rounded-[15px]">{{ $totalCompleted }} de {{ $totalTasks }}</span>
                    </div>
                </div>
                
                <hr class="border-[#333333] mt-5">
            </section>

            <section class="w-[965px] mx-auto mt-10"> 
                @forelse ($tasks as $task)
                <div class="flex justify-between items-center gap-2 text-white h-[50px] p-[15px_20px] text-base rounded my-5 bg-[#262626]">
                    <div class="flex items-center gap-2">
                        <input class="w-5 h-5 rounded mr-5 bg-transparent" type="checkbox" name="completed" id="completed-{{ $task->id }}" {{ $task->completed ? 'checked' : '' }}
                        onchange="updateTask({{ $task->id }}, this.checked)">
                        <p style="{{ $task->completed ? 'text-decoration: line-through; color: #808080;' : '' }}">
                            {{ $task->task }}
                        </p>
                    </div>
                    <form class="m-0 pt-1" action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Deseja excluir essa tarefa?')">
                        @csrf
                        @method('DELETE')
                        <button class="border-none bg-none cursor-pointer" type="submit">
                            <img class="w-[30px] h-[30px]" src="{{ asset('images/trash.svg') }}" alt="Lixeira para deletar tarefa">
                        </button>
                    </form>
                </div>
                    @empty
                    <div class="flex flex-col items-center text-center">
                        <img class="w-[70px] h-[50px]" src="{{ asset('images/clipboard.svg') }}" alt="Ícone prancheta">
                        <p class="font-bold text-[#7F7F7F]">Você ainda não tem tarefas cadastradas</p>
                        <p class="text-[#7F7F7F]">Crie tarefas e organize seus itens a fazer</p>
                    </div>
                @endforelse

                <div class="pagination">
                    {{ $tasks->links() }}
                </div>
            </section>
        </main>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </body>