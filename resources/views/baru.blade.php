

<div class="top-bar">
    <h1>Surat Keterangan <span id="nama_surat">{{ $jenis_surat }}</span></h1>
    <div class="breadcrumbs">Nomer : {{ $nomor }}</div>
</div>
<div id="stylized" class="select-bar">
    <div class="info proses"></div>        
    <form id="form" name="form" method="post" action="{{ url('simpan_surat') }}">
        <!-- Form fields -->
        <label>Nama Warga
            <span class="small">Pemohon surat</span>
        </label>
        <input type="text" name="nama" id="nama" class="isian tampil" value="{{ $nama }}"/>
        <span class="ket"></span>
        <!-- Other fields here -->
        {{-- {!! $field_tambahan !!} --}}
        <label>Yang Tanda Tangan
            <span class="small">Pihak yang mengeluarkan surat</span>
        </label>
        <select onchange="isi_nip(this)">
            <option value="kades">Kades</option>
            <option value="sekdes">Sekdes</option>
        </select>
        <input type="hidden" id="tanda_tangan" value="{{ $sekdes }}" />
        <input type="hidden" id="nip" value="" />
        <button type="submit" class="isian">Simpan</button>
    </form>
</div>

<!-- Print preview surat -->
<div id="cetak" style="display:none;position:absolute;" onclick="cetak(this)">
    <img src="img/print.png" />
</div>
<div id="surat_tampil" style="display:none;">
    <!-- Awal kepala surat -->
    <div id="kepala_surat">
        <img src="img/gresik.jpg" width="100px" height="100px" id="logo_surat" valign="baseline"/>
        <strong>PEMERINTAHAN KABUPATEN {{ strtoupper($kabupaten) }}<br/>
        KECAMATAN  {{ strtoupper($kecamatan) }}<br/>
        DESA  {{ strtoupper($desa) }}<br/></strong>
        {{ ucwords($jalan_desa) }} 
    </div>
    <!-- Akhir kepala surat -->
    <div class="garis"></div>
    <div id="nomer_surat">
        <div style="text-transform:uppercase;text-decoration:underline;font-weight:bolder">Surat Keterangan {{ $jenis_surat }}</div>
        <div>Nomer : {{ $nomor }}</div>
    </div>
    <div id="par_pembuka">
        <span class="masuk_alinea">&nbsp;</span>Yang bertanda tangan dibawah ini , 
        Kepala Desa {{ $kepala_desa}}, 
        Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }} menerangkan dengan 
        sebenarnya bahwa orang tersebut dibawah ini :
    </div>
    <div id="content_surat">
        <!-- Content will be populated dynamically -->
    </div>
    <div id="par_penutup">
        <span class="masuk_alinea">&nbsp;</span>Demikian Surat Keterangan ini diberikan, untuk 
        dapat digunakan sebagaimana mestinya.
    </div>
    <div class="tanda_tangan" id="ybs" >
        <div>&nbsp;</div>
        <div class="kosong">Yang Bersangkutan</div>
        <div id="nama_pemohon">{{ $nama }}</div>
    </div>    
    <div class="tanda_tangan" style="float:right">
        <div>Duduksampeyan, {{ $tanggal }}</div>
        <div class="kosong" id="pejabat">{{ $sekdes}}</div>
        <div id="nama_pejabat">
            <span style="text-transform:uppercase;text-decoration:underline">{{ $kepala_desa }}</span>
        </div>
    </div>
</div>
