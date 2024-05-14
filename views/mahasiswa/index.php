<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project AJAX</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(207, 207, 207);
        }
        .container-fluid {
            background: linear-gradient(to right, rgb(111, 207, 242), rgb(4, 147, 135));
            padding: 2rem 0;
        }
        .container {
            margin-top: 2rem;
        }
        .mt-5 {
            margin-top: 5rem;
        }
        .mt-3 {
            margin-top: 3rem;
        }
        /* Search Bar */
        .search-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-container input[type=text] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        .search-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">

    <h1 class="text-center" style="font-family: 'Roboto', sans-serif">Chasoul Database System</h1>
    <p class="text-center">12522028 <br> Teknik Informatika Semester 4</p>
</div>

<div class="modal fade" id="modalMahasiswa" tabindex="-1" role="dialog" aria-labelledby="modalMahasiswaLabel" aria-hidden="true">
</div>

<div>
    <form id="form-mahasiswa" action="/mahasiswa/store" method="POST" style="float: left; width: 30%; margin-left: 30px; margin-top: 25px;">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">{{ .title }}</h5>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="nama_lengkap" value="{{ .mahasiswa.NamaLengkap }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Gender</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option {{ if eq .mahasiswa.JenisKelamin "Man" }} selected {{ end }} value="Man">Man</option>
                        <option {{ if eq .mahasiswa.JenisKelamin "Woman" }} selected {{ end }} value="Woman">Woman</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Place</label>
                    <input type="text" name="tempat_lahir"  value="{{ .mahasiswa.TempatLahir }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Date of Birth</label>
                    <input type="date" name="tanggal_lahir"  value="{{ .mahasiswa.TanggalLahir }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <textarea name="alamat" class="form-control">{{ .mahasiswa.Alamat }}</textarea>
                </div>
                <br>
                <div class="modal-footer">
                    <div style="float: left;">
                        {{ if .mahasiswa.Id }}
                            <input type="hidden" name="id" value="{{ .mahasiswa.Id }}">
                           
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        {{ else }}
                          
                            <button type="submit" class="btn btn-primary">Save Data</button>
                        {{ end }}
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div style="float: right; width: 60%; margin-right: 20px; margin-top: -20px">
    <div class="container mt-5">
        <div class="search-container mt-3">
            <input type="text" id="searchInput" placeholder="Search...">
        </div>
        
        <div style="max-height: 390px; overflow-y: auto;">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Place, Date of Birth</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{ .data }}
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        var originalTableBody = $("#tableBody").html(); // Store the original HTML of the table body

        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#tableBody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            if ($("#tableBody tr:visible").length === 0) {
                $("#tableBody").html('<tr><td colspan="6">Data not found</td></tr>');
                setTimeout(function () {
                    $("#tableBody").html(originalTableBody);
                }, 1500); 
            }
        });
    });
</script>


<script>
    var site_url = "http://localhost:8000/";

    $(document).ready(function(){
        $('.add-mahasiswa').click(function(){
            $.get(site_url + "mahasiswa/get_form", function(html){
                $('#modalMahasiswa').html(html).modal('show')
            });     
        });

        $(document).on('click', '.edit-mahasiswa', function(){
            var id = $(this).attr('data-id');
            $.get(site_url + "mahasiswa/get_form?id=" + id, function(html){
                $('#modalMahasiswa').html(html).modal('show')
            });     
        });

        $(document).on('click', '.delete-mahasiswa', function(){
            var id = $(this).attr('data-id');
            var confirmDelete = confirm("Apakah Anda yakin ingin menghapus data?");
            if (confirmDelete == true) {
                $.post(site_url + "mahasiswa/delete", {id: id}, function(response){
                    $('tbody').html(response.data);
                }, 'JSON');
            }
        });

        $(document).on('submit', '#form-mahasiswa', function(e){
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response){
                    $('tbody').html(response.data)
                    $('#modalMahasiswa').modal('hide')
                },
                error: function(response){
                    console.log(response)
                }
            })
        });

        // Search Logic
        $('#searchInput').on('input', function(){
            var keyword = $(this).val().toLowerCase();
            var rows = $('tbody tr');

            rows.each(function(){
                var nama = $(this).find('td:eq(1)').text().toLowerCase();
                var gender = $(this).find('td:eq(2)').text().toLowerCase();
                var birthPlaceDate = $(this).find('td:eq(3)').text().toLowerCase();
                var address = $(this).find('td:eq(4)').text().toLowerCase();

                if (nama.includes(keyword) || gender.includes(keyword) || birthPlaceDate.includes(keyword) || address.includes(keyword)){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

</body>
</html>
