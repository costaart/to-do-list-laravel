<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>

    <body>
        <header>
            <div id="div-header" class="container mx-auto">
                <div id="div-2-header">
                    <div>
                        <img src="{{ asset('images/rocket.svg') }}" alt="Logo">
                    </div>
                    <div id="div-3-header">
                        <span style="color: #4EA8DE;font-size: 36px; font-weight: 720">to</span><span style="color: #5E60CE;font-size: 36px;font-weight: 720">do</span>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div id="div-1-main">
                <form action="{{ url('/tasks') }}" method="POST">
                    <input id="input-task" required maxlength="105"  type="text" name="task" placeholder="Digite sua tarefa">
                    <button id="button-task" type="submit">Adicionar <i class="fa-solid fa-plus fa-sm"></i></button>
                    @csrf 
                </form>
            </div>

            <section>
                <div id="div-1-section">
                    <div id="div-2-section">
                        <span id="created-tasks" style="color: #4EA8DE; font-weight: 720;">Tarefas criadas</span>
                        <span style="color: white; font-weight: bold; font-size: 14px; background-color: #262626; padding: 3px 8px 3px 8px; border-radius: 15px">{{ $totalTasks }}</span>
                    </div>
                    <div id="div-2-section">
                        <span style="color: #5E60CE; font-weight: 720;">Concluídas</span>
                        <span style="color: white; font-weight: bold; font-size: 14px; background-color: #262626; padding: 3px 8px 3px 8px; border-radius: 15px">{{ $totalCompleted }} de {{ $totalTasks }}</span>
                    </div>
                </div>
                
                <hr style="border-color: #333333; margin-top: 20px">
            </section>

            <section> 
                @forelse ($tasks as $task)
                <div id="section-tasks-div-1">
                    <div id="section-tasks-div-2">
                        <input id="checkbox" type="checkbox" name="completed" id="completed-{{ $task->id }}" {{ $task->completed ? 'checked' : '' }}
                        onchange="updateTask({{ $task->id }}, this.checked)">
                        <p style="{{ $task->completed ? 'text-decoration: line-through; color: #808080;' : '' }}">
                            {{ $task->task }}
                        </p>
                    </div>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Deseja excluir essa tarefa?')"  style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="border: none; background: none; cursor: pointer;">
                            <img src="{{ asset('images/trash.svg') }}" alt="Lixeira para deletar tarefa" style="width: 30px; height: 30px;">
                        </button>
                    </form>
                </div>
                    @empty
                    <div id="empty-div">
                        <img src="{{ asset('images/clipboard.svg') }}" alt="Ícone prancheta" style="width: 50px; height: 70px;">
                        <p style="font-weight: bold">Você ainda não tem tarefas cadastradas</p>
                        <p>Crie tarefas e organize seus itens a fazer</p>
                    </div>
                @endforelse

                <div class="pagination">
                    {{ $tasks->links() }}
                </div>
            </section>
        </main>
        <script src="{{ asset('js/tasks.js') }}"></script>
    </body>