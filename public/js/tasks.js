function updateTask(taskId, isChecked) {
    fetch(`/tasks/${taskId}`, {
        method: 'POST', 
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Obtém o token CSRF
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _method: 'PUT',  
            completed: isChecked
        })
    })
    .then(response => {
        if (response.ok) {
            console.log('Tarefa concluída com sucesso!');
            window.location.reload();
        } else {
            console.error(response);
        }
    })
    .catch(error => console.error('Erro na requisição:', error));
}

