{{ $nomor := 0 }}
{{ range .mahasiswa }}
    <tr>
        {{ $nomor = increment $nomor 1 }}
        <td>{{ $nomor }}</td>
        <td>{{ .NamaLengkap }}</td>
        <td>{{ .JenisKelamin }}</td>
        <td>{{ .TempatLahir }}, {{ .TanggalLahir }}</td>
        <td>{{ .Alamat }}</td>
        <td>
            <button data-id="{{ .Id }}" class="btn btn-danger btn-sm delete-mahasiswa">
                <i class="fas fa-trash-alt"></i> 
            </button>
            <button data-id="{{ .Id }}" class="btn btn-warning btn-sm edit-mahasiswa">
                <i class="fas fa-edit"></i> 
            </button>
        </td>
    </tr>
{{ end }}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
