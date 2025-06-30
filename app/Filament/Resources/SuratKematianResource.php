<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKematianResource\Pages;
use App\Filament\Resources\SuratKematianResource\RelationManagers;
use App\Models\surat_keterangan_kematian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use Filament\Forms\Components\DatePicker;
class SuratKematianResource extends Resource
{
    protected static ?string $model = surat_keterangan_kematian::class;
    protected static ?string $navigationGroup = 'Surat-surat';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $slug = 'surat-kematian';
    public static function getPluralLabel(): string
    {
        return 'Surat Kematian';  
    }

    public static function getLabel(): string
    {
        return 'Surat Kematian'; 
    }
    public static function slug(): string
    {
        return 'surat-kematian'; 
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kepala Keluarga')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kepala_keluarga')
                            ->label('Nama Kepala Keluarga')
                            ->required()
                            ->autocapitalize('words')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nomor_kepala_keluarga')
                            ->label('Nomor Kepala Keluarga')
                            ->required()
                            ->maxLength(255),
                    ]),
                
                Forms\Components\Section::make('Jenazah')
                    ->schema([
                        Forms\Components\TextInput::make('NIK')
                            ->label('NIK Jenazah')
                            ->required()
                            ->maxLength(16),
                        Forms\Components\TextInput::make('nama_jenazah')
                            ->label('Nama Jenazah')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),
                     
                        Forms\Components\Grid::make(2)->schema([ 
                            DatePicker::make('tanggal_lahir_jenazah')
                                ->label('Tanggal Lahir')
                                ->native(false)
                                ->displayFormat('d F Y')
                                ->closeOnDateSelection()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $birthDate = new \DateTime($state);
                                    $today = new \DateTime();
                                    $age = $today->diff($birthDate)->y;
                                    $set('umur_jenazah', $age);
                                }),
                            Forms\Components\TextInput::make('umur_jenazah')
                                ->label('Umur')
                                ->numeric()
                                ->required(),
                        ]),
                        Forms\Components\TextInput::make('tempat_kelahiran')
                            ->label('Tempat Kelahiran')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('agama')
                            ->placeholder('Pilih opsi')
                            ->label('Agama')
                            ->options([
                                'islam' => 'Islam',
                                'kristen' => 'Kristen',
                                'hindu' => 'Hindu',
                                'budha' => 'Budha',
                                'konghucu' => 'Konghucu',
                                ])
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('pekerjaan')
                            ->label('Pekerjaan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('alamat_jenazah')
                            ->label('Alamat')
                            ->required(),

                        Forms\Components\TextInput::make('desa_kelurahan_jenazah')
                            ->label('Desa/Kelurahan')
                            ->required()
                            ->maxLength(255)
                            ->default('KAMAL'),
                        Forms\Components\TextInput::make('kecamatan_jenazah')
                            ->label('Kecamatan')
                            ->required()
                            ->maxLength(255)
                            ->default('BULU'),
                        Forms\Components\TextInput::make('kabupaten_kota_jenazah')
                            ->label('Kabupaten/Kota')
                            ->required()
                            ->maxLength(255)
                            ->default('SUKOHARJO'),
                        
                        Forms\Components\TextInput::make('provinsi_jenazah')
                            ->label('Provinsi')
                            ->required()
                            ->maxLength(255)
                            ->default('JAWA TENGAH'),

                        
                        Forms\Components\TextInput::make('anak_ke')
                            ->label('Anak Ke')
                            ->numeric()
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_kematian_jenazah')
                            ->label('Tanggal Kematian')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->closeOnDateSelection()
                            ->required(),

                        Forms\Components\TimePicker::make('pukul')
                            ->label('Pukul Kematian')
                            ->seconds(false)  
                            ->format('H:i')  
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Select::make('sebab_kematian')
                            ->label('Sebab kematian')
                            ->options([
                                'Sakit biasa / tua' => 'Sakit biasa / tua',
                                'Wabah Penyakit' => 'Wabah Penyakit',
                                'Kecelakaan' => 'Kecelakaan',
                                'Kriminalitas' => 'Kriminalitas',
                                'Bunuh Diri' => 'Bunuh Diri',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->native(false)
                            ->required(),


                        Forms\Components\TextInput::make('tempat_kematian')
                            ->label('Tempat Kematian')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('yang_menerangkan')
                            ->label('Yang Menerangkan')
                            ->options([
                                'Dokter' => 'Dokter',
                                'Tenaga Kesehatan' => 'Tenaga Kesehatan',
                                'Kepolisian' => 'Kepolisian',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->native(false)
                            ->required(),
                    ]),

                // Mother Details Section
            Forms\Components\Section::make('Data Ibu')
                ->schema([
                    Forms\Components\TextInput::make('nik_ibu')
                        ->label('NIK Ibu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nama_ibu')
                        ->label('Nama Ibu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Grid::make(2)->schema([ 
                        DatePicker::make('tanggal_lahir_ibu')
                            ->label('Tanggal Lahir Ibu')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->closeOnDateSelection()
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                 if ($state) {
                                    $birthDate = new \DateTime($state);
                                    $today = new \DateTime();
                                    $age = $today->diff($birthDate)->y;
                                    $set('umur_ibu', $age);
                                } else {
                                    $set('umur_ibu', '-');
                                }
                            }),
                        Forms\Components\TextInput::make('umur_ibu')
                            ->label('Umur Ibu')
                            ->numeric()
                            ->nullable()
                            ->default('-'),
                    ]),
                    Forms\Components\TextInput::make('pekerjaan_ibu')
                        ->label('Pekerjaan Ibu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('alamat_ibu')
                        ->label('Alamat Ibu')
                        ->required(),

                    Forms\Components\TextInput::make('desa_kelurahan_ibu')
                        ->label('Desa/Kelurahan Ibu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kecamatan_ibu')
                            ->label('Kecamatan Ibu')
                            ->required()
                            ->maxLength(255),
                    Forms\Components\TextInput::make('kabupaten_kota_ibu')
                        ->label('Kabupaten/Kota Ibu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('provinsi_ibu')
                        ->label('Provinsi Ibu')
                        ->required()
                        ->maxLength(255),

                ]),

            // Father Details Section
            Forms\Components\Section::make('Data Ayah')
                ->schema([
                    Forms\Components\TextInput::make('nik_ayah')
                        ->label('NIK Ayah')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nama_ayah')
                        ->label('Nama Ayah')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Grid::make(2)->schema([ 
                        DatePicker::make('tanggal_lahir_ayah')
                            ->label('Tanggal Lahir Ayah')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->closeOnDateSelection()
                            ->required()
                            ->nullable() // Make the field nullable
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $birthDate = new \DateTime($state);
                                    $today = new \DateTime();
                                    $age = $today->diff($birthDate)->y;
                                    $set('umur_ayah', $age);
                                } else {
                                    $set('umur_ayah', '-');
                                }
                            }),
                        Forms\Components\TextInput::make('umur_ayah')
                            ->label('Umur Ayah')
                            ->numeric()
                            ->required()
                            ->nullable()
                            ->default('-'),
                        ]),

                    Forms\Components\TextInput::make('pekerjaan_ayah')
                        ->label('Pekerjaan Ayah')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('alamat_ayah')
                        ->label('Alamat Ayah')
                        ->required(),
                    Forms\Components\TextInput::make('desa_kelurahan_ayah')
                        ->label('Desa/Kelurahan Ayah')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kecamatan_ayah')
                        ->label('Kecamatan Ayah')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kabupaten_kota_ayah')
                        ->label('Kabupaten/Kota Ayah')
                        ->required()
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('provinsi_ayah')
                        ->label('Provinsi Ayah')
                        ->required()
                        ->maxLength(255),
                    
                ]),
            // Reporter Details Section
            Forms\Components\Section::make('Data Pelapor')
                ->schema([
                    Forms\Components\TextInput::make('nik_pelapor')
                        ->label('NIK Pelapor')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nama_pelapor')
                        ->label('Nama Pelapor')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('umur_pelapor')
                        ->label('Umur Pelapor')
                        ->numeric()
                        ->required(),
                    Forms\Components\Select::make('jenis_kelamin_pelapor')
                        ->label('Jenis Kelamin Pelapor')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('pekerjaan_pelapor')
                        ->label('Pekerjaan Pelapor')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('alamat_pelapor')
                        ->label('Alamat Pelapor')
                        ->required(),
                    Forms\Components\TextInput::make('desa_kelurahan_pelapor')
                        ->label('Desa/Kelurahan Pelapor')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kecamatan_pelapor')
                        ->label('Kecamatan Pelapor')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kabupaten_kota_pelapor')
                        ->label('Kabupaten/Kota Pelapor')
                        ->required()
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('provinsi_pelapor')
                        ->label('Provinsi Pelapor')
                        ->required()
                        ->maxLength(255),
                ]),

            // Witness 1 Section
            Forms\Components\Section::make('Data Saksi I')
                ->schema([
                    Forms\Components\TextInput::make('nik_saksi1')
                        ->label('NIK Saksi I')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nama_saksi1')
                        ->label('Nama Saksi I')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('umur_saksi1')
                        ->label('Umur Saksi I')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('pekerjaan_saksi1')
                        ->label('Pekerjaan Saksi I')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('alamat_saksi1')
                        ->label('Alamat Saksi I')
                        ->required(),
                    Forms\Components\TextInput::make('desa_kelurahan_saksi1')
                        ->label('Desa/Kelurahan Saksi I')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\TextInput::make('kecamatan_saksi1')
                            ->label('Kecamatan Saksi I')
                            ->required()
                            ->maxLength(255),
                    Forms\Components\TextInput::make('kabupaten_kota_saksi1')
                        ->label('Kabupaten/Kota Saksi I')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('provinsi_saksi1')
                        ->label('Provinsi Saksi I')
                        ->required()
                        ->maxLength(255),
                ]),

            // Witness 2 Section
            Forms\Components\Section::make('Data Saksi II')
                ->schema([
                    Forms\Components\TextInput::make('nik_saksi2')
                        ->label('NIK Saksi II')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nama_saksi2')
                        ->label('Nama Saksi II')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('umur_saksi2')
                        ->label('Umur Saksi II')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('pekerjaan_saksi2')
                        ->label('Pekerjaan Saksi II')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('alamat_saksi2')
                        ->label('Alamat Saksi II')
                        ->required(),
                    Forms\Components\TextInput::make('desa_kelurahan_saksi2')
                        ->label('Desa/Kelurahan Saksi II')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kecamatan_saksi2')
                        ->label('Kecamatan Saksi II')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kabupaten_kota_saksi2')
                            ->label('Kabupaten/Kota Saksi II')
                            ->required()
                            ->maxLength(255),
                    Forms\Components\TextInput::make('provinsi_saksi2')
                        ->label('Provinsi Saksi II')
                        ->required()
                        ->maxLength(255),


                ]),

                Forms\Components\Section::make('Desa')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->required()
                            ->maxLength(255)
                            ->hint('Nomor surat terakhir: ' . surat_keterangan_kematian::latest('created_at')->value('nomor_surat'))
                            ->placeholder('474.3/xxx/mm/yyyy'),
                        Forms\Components\Select::make('jabatan')
                            ->label('Pilih Jabatan TTD')
                            ->options([
                                'kepala_desa' => 'Kepala Desa Kamal',
                                'sekdes' => 'Sekretaris Desa',
                                'kaur_tu' => 'Kaur TU',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')->label('Nomor Surat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_jenazah')->label('Nama Jenazah')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kematian_jenazah')
                    ->label('Tanggal Kematian')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)
                        ->locale('id') // Set locale to Indonesian
                        ->translatedFormat('d F Y')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)
                        ->locale('id') // Set locale to Indonesian
                        ->translatedFormat('d F Y')),
            ])
            ->headerActions([
                Action::make('Export to Excel by Month')
                    ->label('Ekspor Excel')
                    ->form([
                        Forms\Components\DatePicker::make('month')
                            ->label('Pilih Bulan')
                            ->format('Y-m') // Formatting it to Year-Month
                            ->displayFormat('F Y') // Display format as 'Month Year'
                            ->required()
                            ->native(false)
                            ->closeOnDateSelection(),
                    ])
                    ->action(function (array $data) {
                        return redirect()->route('export.suratKematianByMonth', ['month' => $data['month']]);
                    })
                    ->icon('heroicon-o-arrow-down-tray'),
            ])


            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('showPDF')
                    ->label('Show PDF')
                    ->url(fn (surat_keterangan_kematian $record) => route('suratKematian.show', ['id' => $record->id]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-down-tray'),
                Action::make('downloadPDF')
                    ->label('Download PDF')
                    ->url(fn (surat_keterangan_kematian $record) => route('download.kematian', ['id' => $record->id]))
                    ->icon('heroicon-o-arrow-down-tray'),
                Tables\Actions\DeleteAction::make(),
              
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKematians::route('/'),
            'create' => Pages\CreateSuratKematian::route('/create'),
            'edit' => Pages\EditSuratKematian::route('/{record}/edit'),
        ];
    }
}
