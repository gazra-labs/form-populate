<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>jQuery Form Populate</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <?php

    $rows = [
        ['id' => 1, 'title' => 'task 1', 'description' => 'lorem ipsum...'],
        ['id' => 2, 'title' => 'task 2', 'description' => 'lorem ipsum...'],
        ['id' => 3, 'title' => 'task 3', 'description' => 'lorem ipsum...'],
        ['id' => 4, 'title' => 'task 4', 'description' => 'lorem ipsum...'],
        ['id' => 5, 'title' => 'task 5', 'description' => 'lorem ipsum...'],
        ['id' => 6, 'title' => 'task 6', 'description' => 'lorem ipsum...'],
    ];

    ?>
    <div class="container">
        <form class="form-horizontal" id="taskForm" role="form" style="display:none;">
            <h2> <span class="taskFormHeading">Add</span> Tasks</h2>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="taskTitle">Task Title</label>
                <div class="col-sm-9">
                    <input type="text" name="title" class="form-control" autofocus="" id="taskTitle" placeholder="Task Title">
                    <span class="help-block">Enter task title here...</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="description">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" placeholder="description" class="form-control" id="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3 btn-group">
                    <input type="hidden" name="id" />
                    <button type="submit" class="btn btn-primary ">Submit</button>
                    <button type="button" class="btn btn-light " onclick="$('#taskForm').slideUp();">Cancel</button>
                </div>
            </div>
        </form> <!-- /form -->

        <h3>Manage task <button class="btn btn-info addTask float-right">Add Task</button> </h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['title'] ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td>
                            <button class="btn btn-primary editTask" data-json='<?php echo json_encode($row); ?>' type="button">Edit</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
    <script>
        $.fn.clear_form_elements = function() {

            if ($(this).prop('tagName') == 'FORM') {
                $(this)[0].reset();
            } else {
                $(this).find(':input').each(function() {
                    switch ($(this).prop('type')) {
                        case 'checkbox':
                        case 'radio':
                            $(this).prop('checked', false);
                            break;
                        default:
                            $(this).val('');
                            break;
                    }
                });
            }
        }
        $.fn.fillEditForm = function(rowJson) {
            $(this).clear_form_elements();

            $.each(rowJson, function(key, value) {
                var fieldName = $("[name='" + key + "']");
                switch (fieldName.prop("type")) {
                    case "radio":
                    case "checkbox":
                        fieldName.each(function() {
                            if ($(this).attr('value') == value) {
                                $(this).prop("checked", true);
                            }
                        });
                        break;
                    case "select-one":
                        fieldName.find('option[value=' + value + ']').prop('selected', true);
                        break;
                    case "select-multiple":
                        fieldName.multiselect('selectNone');
                        setTimeout(function() {
                            $.each(value.split(","), function(i, e) {
                                fieldName.multiselect('select', e);
                            });
                        }, 1000);
                        break;
                    default:
                        fieldName.val(value);
                        break;
                }
            });
        }

        $(document).ready(function() {
            $(document).on('click', '.editTask', function(event) {
                event.preventDefault();
                var rowJson = $(this).data("json");
                $("#taskForm").fillEditForm(rowJson);
                $('.taskFormHeading').text('Edit ');
                $("#taskForm").slideDown();
            });

            $(document).on('click','.addTask',function(){
                $("#taskForm").clear_form_elements();
                $('.taskFormHeading').text('Add ');
                $("#taskForm").slideDown();
            });

        });
    </script>

</body>

</html>
