<?php
include 'connect.php';

if(isset($_POST['submit'])){
    $task = $_POST['task'];
    $dec = $_POST['description'];
    $sql = "INSERT INTO tasklist (task, description) VALUES ('$task', '$dec')";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        echo("Inserted");
    } else {
        echo("error: " . mysqli_error($conn));
    }
}
$sql = "SELECT * FROM tasklist";
$result = mysqli_query($conn, $sql);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 20px;
        background-image: url("todo.jpeg");
        background-size: cover;
        background-repeat: no-repeat;
    }
    
    .todo-container {
        max-width: 1000px;
        max-height: 1000px;
        background-color: rgba(240, 248, 255, 0.825);
        margin: 0 auto;
    }
    
    input {
        width: 70%;
        padding: 8px;
        margin-bottom: 10px;
    }
    
    button {
        padding: 8px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }
    
    button:hover {
        background-color: #45a049;
    }
    
    ul {
        list-style-type: none;
        padding: 0;
    }
    
    li {
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-left: 20px;
        margin-right: 20px;
    }
    
    .delete-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
    }
    
    .delete-button:hover {
        background-color: #d32f2f;
    }

    .list table {
        border-spacing: 10px;
        margin-left: auto;
        margin-right: auto;
    }

    .list th, .list td {
        padding: 10px;
        text-align: left;
        margin-left: 100px;
    }
   </style>
</head>
<body>
    <div class="todo-container">
    <div id="list">
        <h1>Todo List</h1>
       <!-- ... your HTML code ... -->
<form method="post" action="">
    <input type="text" id="taskInput" name="task" placeholder="Add a new task">
    <input type="text" id="descriptionInput" name="description" placeholder="Add a description" style="margin-left:50px;">
    <button type="submit" name="submit" id="submit">Add Task</button>
</form>
<!-- ... your HTML code ... -->

        
<ul id="taskList"></ul>

<div class="list">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th style="margin-left:100px;">Task</th>
                <th style="margin-left:100px;">Description</th>
            </tr>
        </thead>
        <tbody>
        <?php 
$currentId = 1; // Initialize ID counter
foreach ($tasks as $task) : 
?>
    <tr>
        <td><?php echo $currentId++; ?></td>
        <td><?php echo $task['task']; ?></td>
        <td><?php echo $task['description']; ?></td>
        <td>
            <button class="delete-button" onclick="deleteTask(<?php echo $task['id']; ?>)">Delete</button>
        </td>
    </tr>
<?php endforeach; ?>

        </tbody>
    </table>
</div>
</div>
<script>
    // ... your existing JavaScript code ...

    function deleteTask(taskId) {
        const confirmed = confirm('Are you sure you want to delete this task?');
        if (confirmed) {
            const rowToDelete = document.querySelector(`[data-task-id="${taskId}"]`);
            if (rowToDelete) {
                rowToDelete.remove();
                
                fetch('delete_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ taskId: taskId }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Deleted:', data);
                })
                .catch(error => {
                    console.error('Error deleting task:', error);
                });
            }
        }
    }
</script>
</body>
</html>
