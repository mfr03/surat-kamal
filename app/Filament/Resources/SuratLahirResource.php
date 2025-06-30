<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratLahirResource\Pages;
use App\Filament\Resources\SuratLahirResource\RelationManagers;
use App\Models\surat_keterangan_kelahiran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Illuminate\Http\RedirectResponse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class SuratLahirResource extends Resource
{
    protected static ?string $model = surat_keterangan_kelahiran::class;
    protected static ?string $navigationGroup = 'Surat-surat';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $slug = 'surat-kelahiran';
    public static function getPluralLabel(): string
    {
        return 'Surat Kelahiran';  
    }

    public static function getLabel(): string
    {
        return 'Surat Kelahiran'; 
    }
    public static function slug(): string
    {
        return 'surat-kelahiran'; 
    }


    public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Head of Family Section
            Forms\Components\Section::make('Kepala Keluarga')
                ->schema([
                    Forms\Components\TextInput::make('nama_kepala_keluarga')
                        ->label('Nama Kepala Keluarga')
                        ->autofocus()
                        ->required()
                        ->autocapitalize('words')
                        ->maxLength(255),
                 
                    Forms\Components\TextInput::make('nomor_kepala_keluarga')
                        ->label('Nomor Kepala Keluarga')
                        ->required()
                        ->maxLength(255),
                ]),


            // Baby Details Section
            Forms\Components\Section::make('Data Bayi')
                ->schema([
                    Forms\Components\TextInput::make('nama_bayi')
                        ->label('Nama Bayi')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\Select::make('jenis_kelamin_bayi')
                        ->label('Jenis Kelamin Bayi')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ])
                        ->native(false)
                        ->required(),

                    Forms\Components\Select::make('tempat_dilahirkan')
                        ->label('Tempat Dilahirkan')
                        ->options([
                            'Rumah Sakit' => 'Rumah sakit (RS)',
                            'Puskesmas' => 'Puskesmas',
                            'Polindes' => 'Polindes',
                            'Rumah' => 'Rumah',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->native(false)
                        ->required(),
                  
                    Forms\Components\TextInput::make('tempat_kelahiran')
                        ->label('Tempat Kelahiran')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('tanggal_lahir_bayi')
                        ->label('Tanggal Lahir Bayi')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->closeOnDateSelection()
                        ->required(),

                    Forms\Components\TimePicker::make('pukul_lahir')
                        ->label('Pukul Lahir')
                        ->seconds(false)  
                        ->format('H:i')  
                        ->required()
                        ->native(false),

                        
                    Forms\Components\Select::make('jenis_kelahiran')
                        ->label('Jenis Kelahiran')
                        ->options([
                            'Tunggal' => 'Tunggal',
                            'Kembar 2' => 'Kembar 2',
                            'Kembar 3' => 'Kembar 3',
                            'Kembar 4' => 'Kembar 4',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->native(false)

                        ->required(),

                    Forms\Components\Select::make('kelahiran_ke')
                        ->label('Kelahiran ke')
                        ->options([
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                            '11' => '11',
                            '12' => '12',
                            '13' => '13',
                        ])
                        ->native(false)
                        ->required(),
                   
                    Forms\Components\Select::make('penolong_kelahiran')
                        ->label('Penolong Kelahiran')
                        ->options([
                            'Dokter' => 'Dokter',
                            'Bidan/Perawat' => 'Bidan/Perawat',
                            'Dukun' => 'Dukun',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->native(false)
                        ->required(),
                   
                    Forms\Components\TextInput::make('berat_bayi')
                        ->label('Berat Bayi (kg)')
                        ->numeric()
                        ->required()
                        ->step(0.01) // Allows two decimal places
                        ->maxValue(10) // Set a maximum value if needed, e.g., 10 kg
                        ->placeholder('2.5 kg'),

                    Forms\Components\TextInput::make('panjang_bayi')
                        ->label('Panjang Bayi (cm)')
                        ->numeric()
                        ->required()
                        ->maxLength(5),
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
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $birthDate = new \DateTime($state);
                                $today = new \DateTime();
                                $age = $today->diff($birthDate)->y;
                                $set('umur_ibu', $age);
                            }),
                        Forms\Components\TextInput::make('umur_ibu')
                            ->label('Umur Ibu')
                            ->numeric()
                            ->required(), 
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

                    Forms\Components\Select::make('kewarganegaraan_ibu')
                        ->label('Kewarganegaraan Ibu')
                        ->options([
                            'WNI' => 'WNI',
                            'WNA' => 'WNA',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('kebangsaan_ibu')
                        ->label('Kebangsaan Ibu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('tgl_kawin')
                        ->label('Tanggal Pencatatan Perkawinan')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->closeOnDateSelection()
                        ->required(),
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
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $birthDate = new \DateTime($state);
                                $today = new \DateTime();
                                $age = $today->diff($birthDate)->y;
                                $set('umur_ayah', $age);
                            }),
                        Forms\Components\TextInput::make('umur_ayah')
                            ->label('Umur Ayah')
                            ->numeric()
                            ->required(), 
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
                    Forms\Components\Select::make('kewarganegaraan_ayah')
                        ->label('Kewarganegaraan Ayah')
                        ->options([
                            'WNI' => 'WNI',
                            'WNA' => 'WNA',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('kebangsaan_ayah')
                        ->label('Kebangsaan Ayah')
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
            Forms\Components\Section::make('Data Desa')
                ->schema([

                    Forms\Components\TextInput::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->maxLength(255)
                        ->columnSpan(1)
                        ->required()
                        ->placeholder('474.1/xxx/mm/yyyy')
                        ->hint('Nomor surat terakhir: ' . surat_keterangan_kelahiran::latest('created_at')->value('nomor_surat'))
                        ->reactive(),

                    Forms\Components\Select::make('jabatan')
                        ->label('Pilih Jabatan TTD')
                        ->columnSpanFull()
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
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_bayi')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_kepala_keluarga')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)
                        ->locale('id') // Set locale to Indonesian
                        ->translatedFormat('d F Y')),
            ])
            ->defaultSort('created_at', 'desc') 

            ->filters([
                //
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
                        return redirect()->route('export.suratKelahiranByMonth', ['month' => $data['month']]);
                    })
                    ->icon('heroicon-o-arrow-down-tray'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                 Action::make('showPDF')
                    ->label('Show PDF')
                    ->url(fn (surat_keterangan_kelahiran $record) => route('surat.show', ['id' => $record->id]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-down-tray'),

                    Action::make('downloadPDF')
                    ->label('Download PDF')
                    ->url(fn (surat_keterangan_kelahiran $record) => route('download.lahir', ['id' => $record->id]))
                    ->icon('heroicon-o-arrow-down-tray'),
                    Tables\Actions\DeleteAction::make(),
                    
            ])
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public function viewBirthCertificate($recordId)
    {
        return redirect()->route('surat.show', ['id' => $recordId]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratLahirs::route('/'),
            'create' => Pages\CreateSuratLahir::route('/create'),
            'edit' => Pages\EditSuratLahir::route('/{record}/edit'),
        ];
    }
}
