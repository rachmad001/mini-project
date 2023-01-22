@extends('sidebar')

@section('header')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
<style>
    .my-forms {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(186, 186, 186, 0.5);
        z-index: 2;
    }

    .my-forms .width-500 {
        width: 500px;
        margin: auto;
        margin-top: 25px;
    }

    .bg-white {
        background-color: #ffffff;
    }

    h2 {
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="my-forms">
    <div class="container p-0 width-500 rounded bg-white overflow-hidden" id="addForm">
        <div class="d-flex pt-2 pb-2 pl-3 pr-3 justify-content-between align-items-center bg-primary">
            <h2>Form Tambah</h2>
            <button class="btn btn-danger" onclick="formClose()">X</button>
        </div>
        <div class="container">
            <form id="TambahForm">
                <span>Project Name</span>
                <input type="text" name="project_name" id="project" class="form-control"><br>
                <span>Client</span>
                <select name="client_id" id="client" class="form-control">
                </select><br>
                <span>Project Start</span>
                <input type="date" name="project_start" id="start" class="form-control"><br>
                <span>Project End</span>
                <input type="date" name="project_end" id="end" class="form-control"><br>
                <span>Project Status</span>
                <select name="project_status" id="status" class="form-control">
                    <option value="open">OPEN</option>
                    <option value="doing">DOING</option>
                    <option value="done">DONE</option>
                </select>
            </form>
        </div>
        <div class="container mt-2 pb-2">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" onclick="addData()">Tambah</button>
                <button class="btn btn-danger ml-1" onclick="formClose()">Batal</button>
            </div>
        </div>
    </div>
    <div class="container p-0 width-500 rounded bg-white overflow-hidden" id="editForm">
        <div class="d-flex pt-2 pb-2 pl-3 pr-3 justify-content-between align-items-center bg-primary">
            <h2>Form Edit</h2>
            <button class="btn btn-danger" onclick="formClose()">X</button>
        </div>
        <div class="container">
            <form id="UbahForm">
                <div style="display: none;"><input type="text" name="project_id" id="edit-project_id" readonly></div>
                <span>Project Name</span>
                <input type="text" name="project_name" id="edit-project" class="form-control" value="testing"><br>
                <span>Client</span>
                <select name="client_id" id="edit-client" class="form-control">
                    <!-- <option value="nec">nec</option>
                    <option value="nec">nec</option> -->
                </select><br>
                <span>Project Start</span>
                <input type="date" name="project_start" id="edit-start" class="form-control"><br>
                <span>Project End</span>
                <input type="date" name="project_end" id="edit-end" class="form-control"><br>
                <span>Project Status</span>
                <select name="project_status" id="edit-status" class="form-control">
                    <option value="open">OPEN</option>
                    <option value="doing">DOING</option>
                    <option value="done">DONE</option>
                </select>
            </form>
        </div>
        <div class="container mt-2 pb-2">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" onclick="UpdateData()">Ubah</button>
                <button class="btn btn-danger ml-1" onclick="formClose()">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="container rounded shadow">
    <form id="filter-data">
        <div class="row pt-2 pb-2">
            <div class="col-3 d-flex align-items-center justify-content-center">
                <span>Filter</span>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-5">
                        <span>Project Name</span>
                    </div>
                    <div class="col-2">
                        <span>Client</span>
                    </div>
                    <div class="col-2">
                        <span>Status</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <input type="text" name="project" id="project-filter" class="form-control">
                    </div>
                    <div class="col-2">
                        <select name="client" id="client-filter" class="form-control">
                            <option value="#">All Client</option>
                            <!-- <option value="NEC">NEC</option> -->
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="status" id="status-filter" class="form-control">
                            <option value="#">All Status</option>
                            <option value="open">OPEN</option>
                            <option value="doing">DOING</option>
                            <option value="done">DONE</option>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-success" onclick="filter()" type="button">Search</button>
                        <button class="btn btn-secondary" onclick="clearFilter()" type="button">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container mt-3">
    <button class="btn btn-primary" onclick="formAdd()">New</button>
    <button class="btn btn-danger" onclick="deleteData()">Delete</button>
</div>
<div class="container mt-1">
    <form id="listid">
        <table class="table table-striped table-bordered" id="mytable">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id=""></th>
                    <th>Action</th>
                    <th>Project Name</th>
                    <th>Client</th>
                    <th>Project Start</th>
                    <th>Project End</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <!-- <tr>
                <td><input type="checkbox" name="" id=""></td>
                <td>Edit</td>
                <td>WMS</td>
                <td>NEC</td>
                <td>28 Jul 2022</td>
                <td>28 Agu 2022</td>
                <td>OPEN</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""></td>
                <td>Edit</td>
                <td>WMS</td>
                <td>NEC</td>
                <td>28 Jul 2022</td>
                <td>28 Agu 2022</td>
                <td>OPEN</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""></td>
                <td>Edit</td>
                <td>WMS</td>
                <td>NEC</td>
                <td>28 Jul 2022</td>
                <td>28 Agu 2022</td>
                <td>OPEN</td>
            </tr> -->
            </tbody>
        </table>
    </form>
</div>
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="paginate.js"></script>
<script>
    formClose();
    var table = $('#mytable').DataTable({
        "dom": "<<t>p>",
        "pageLength": 5
    })

    var client_list = new Paginate([], 0);
    client_list.onChange(listenerClient);
    var timer_client = setInterval(() => {
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var data = JSON.parse(this.responseText);
            client_list.setPerPage(data.length);
            client_list.setData(data);
        }
        xhttp.open("GET", location.origin + "/api/client", true);
        xhttp.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhttp.send();
    }, 1000);

    var data_project = new Paginate([], 0);
    data_project.onChange(listenerData)
    // var timer = setInterval(() => {
    latestData();

    function latestData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var data = JSON.parse(this.responseText);
            data_project.setPerPage(data.length);
            data_project.setData(data);
        }
        xhttp.open("GET", location.origin + "/api/project", true);
        xhttp.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhttp.send();
    }
    // }, 1000);

    function formClose() {
        document.querySelector('.my-forms').style.display = "none";
        document.querySelector('#project').value = "";
    }

    function formAdd() {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var response = this.responseText;
            var data = JSON.parse(response);
            var clients = document.querySelector('#client');
            clients.innerHTML = "";
            for (var i = 0; i < data.length; i++) {
                clients.innerHTML += '<option value="' + data[i].client_id + '">' + data[i].client_name + '</option>'
            }
            document.querySelector('.my-forms').style.display = "block";
            document.querySelector('#addForm').style.display = "block";
            document.querySelector('#editForm').style.display = "none";
        }
        xhr.open("GET", location.origin + "/api/client", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhr.send();
    }

    function addData() {
        var data = new FormData(document.getElementById("TambahForm"));
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var response = JSON.parse(this.responseText);
            if (response.status) {
                alertify.notify(response.msg, 'success', 3, formClose());
                latestData();
            } else {
                alertify.notify(response.msg, 'error', 3, function() {});
            }
        }
        xhr.open("POST", location.origin + "/api/project", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhr.send(data);
    }

    function edit(id) {
        // alertify.notify(id, 'success', 3, function() {});
        var data = new FormData();
        data.append("id", id);
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var data = JSON.parse(this.responseText);
            document.querySelector("#edit-project_id").value = data[0].project_id;
            document.querySelector("#edit-project").value = data[0].project_name;
            document.querySelector("#edit-client").value = data[0].client_id;
            document.querySelector("#edit-start").value = data[0].project_start;
            document.querySelector("#edit-end").value = data[0].project_end;
            document.querySelector("#edit-status").value = data[0].project_status;
            document.querySelector('.my-forms').style.display = "block";
            document.querySelector('#addForm').style.display = "none";
            document.querySelector('#editForm').style.display = "block";
        }
        xhttp.open("POST", location.origin + "/api/project?_method=get", true);
        xhttp.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhttp.send(data);
    }

    function UpdateData() {
        var data = new FormData(document.getElementById("UbahForm"));

        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var response = JSON.parse(this.responseText);
            if (response.status) {
                alertify.notify(response.msg, 'success', 3, formClose);
                latestData();
            } else {
                alertify.notify(response.msg, 'error', 3, function() {});
            }
        }
        xhr.open("post", location.origin + "/api/project?_method=put", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhr.send(data);
    }

    function listenerData(data) {
        $('#mytable').DataTable().clear().destroy();

        var tbody = document.getElementById("tbody");
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        tbody.innerHTML = "";
        tbody.innerHTML += '<form id="listid">'
        for (var i = 0; i < data.length; i++) {
            var start_date = new Date(data[i].project_start);
            var end_date = new Date(data[i].project_end);
            tbody.innerHTML +=
                '<tr>' +
                '<td><input type="checkbox" name="project_id[]" id="" value="' + data[i].project_id + '"></td>' +
                '<td onclick="edit(\'' + data[i].project_id + '\')">Edit</td>' +
                '<td>' + data[i].project_name.toUpperCase() + '</td>' +
                '<td>' + data[i].client_name.toUpperCase() + '</td>' +
                '<td>' + start_date.getDate() + ' ' + monthNames[start_date.getMonth()] + ' ' + start_date.getFullYear() + '</td>' +
                '<td>' + end_date.getDate() + ' ' + monthNames[end_date.getMonth()] + ' ' + end_date.getFullYear() + '</td>' +
                '<td>' + data[i].project_status.toUpperCase() + '</td>' +
                '</tr>'
        }
        tbody.innerHTML += '</form>';

        table = $('#mytable').DataTable({
            "dom": "<<t>p>",
            "pageLength": 5
        })
    }

    function listenerClient(data) {
        var client_filter = document.querySelector('#client-filter');
        client_filter.innerHTML = '<option value="#">All Status</option>';

        var client_edit = document.querySelector('#edit-client');
        client_edit.innerHTML = "";
        for (var i = 0; i < data.length; i++) {
            client_filter.innerHTML += '<option value="' + data[i].client_id + '">' + data[i].client_name.toUpperCase() + '</option>'
            client_edit.innerHTML += '<option value="' + data[i].client_id + '">' + data[i].client_name.toUpperCase() + '</option>'
        }
    }

    function deleteData() {
        alertify.confirm(
            'Konfirmasi Penghapusan',
            'Tekan Ok jika yakin ingin menghapus',
            function() {
                var data = new FormData(document.getElementById("listid"));

                var xhr = new XMLHttpRequest();
                xhr.onload = function() {
                    var response = JSON.parse(this.responseText);
                    if (response.status) {
                        alertify.notify(response.msg, 'success', 3, function() {});
                        latestData();
                    } else {
                        alertify.notify(response.msg, 'error', 3, function() {});
                    }
                }
                xhr.open("post", location.origin + "/api/project?_method=delete", true);
                xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                xhr.send(data);
            },
            function() {
                alertify.error('Cancel')
            });
    }

    function clearFilter() {
        var projects = document.querySelector('#project-filter');
        var clients = document.querySelector('#client-filter');
        var status = document.querySelector('#status-filter');
        status.value = "#";
        clients.value = "#";
        projects.value = "";
        latestData();
    }

    function filter() {
        var data = new FormData(document.getElementById("filter-data"));
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var data = JSON.parse(this.responseText);
            data_project.setPerPage(data.length);
            data_project.setData(data);
        }
        xhr.open("post", location.origin + "/api/project/filter?_method=get", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        xhr.send(data);
    }
</script>
@endsection