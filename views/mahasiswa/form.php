<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ .title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form-mahasiswa" action="/mahasiswa/store" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="nama_lengkap" value="{{ .mahasiswa.NamaLengkap }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Gender</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option {{ if eq .mahasiswa.JenisKelamin `L` }} selected {{ end }} value="Man">Man</option>
                        <option {{ if eq .mahasiswa.JenisKelamin `P` }} selected {{ end }} value="Woman">Woman</option>
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
                    <label for="">Adress</label>
                    <textarea name="alamat" class="form-control">{{ .mahasiswa.Alamat }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                {{ if .mahasiswa.Id }}
                    <input type="hidden" name="id" value="{{ .mahasiswa.Id }}">
               
                    <button type="submit" class="btn btn-primary">Update Data</button>
                {{ else }}
                    
                    <button type="submit" class="btn btn-primary">Save Data</button>
                {{ end }}
            </div>
        </form>
    </div>
</div>