<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratResource\Pages;
use App\Filament\Resources\SuratResource\RelationManagers;
use App\Models\Surat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\Page;
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components;


class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    
    public static function getPluralLabel(): string
    {
        return 'Suratkuu';  
    }

    public static function getLabel(): string
    {
        return 'Suratkuu'; 
    }

     public static function slug(): string
    {
        return 'Suratkuu'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        
                Select::make('jenis_id')
                    ->relationship('jenis', 'name')
                    ->label('Jenis Surat')
                    ->placeholder('Pilih opsi')
                    ->required()
                    ->columnSpanFull()
                    ->live(),
                    
                Select::make('kode_surat')
                    ->label('Kode Surat')
                    ->placeholder('Pilih opsi')
                    ->columnSpan(1)
                    ->options([
                        '470' => '470 - Umum',
                        '300' => '300 - Bank',
                        '330' => '330 - Izin Acara',
                        '900' => '900 - Perbankan',
                    ])
                    ->required()
                    ->reactive(), // This ensures changes to this field trigger reactive updates

                TextInput::make('nomor_surat')
                    ->label('Nomor')
                    ->maxLength(255)
                    ->columnSpan(1)
                    ->required()
                    ->reactive(), // This ensures changes to this field trigger reactive updates

                TextInput::make('letter_number')
                    ->label('Nomor Surat')
                    ->columnSpanFull()
                    ->reactive()  // Make it reactive to changes
                    ->afterStateUpdated(function ($state, callable $set, Get $get) {
                        $kode_surat = $get('kode_surat');
                        $letter_number = $get('nomor_surat');
                        
                        // Convert month to Roman numerals
                        $month = now()->month;
                        $roman_month = match ($month) {
                            1 => 'I',
                            2 => 'II',
                            3 => 'III',
                            4 => 'IV',
                            5 => 'V',
                            6 => 'VI',
                            7 => 'VII',
                            8 => 'VIII',
                            9 => 'IX',
                            10 => 'X',
                            11 => 'XI',
                            12 => 'XII',
                            default => ''
                        };

                        $year = now()->year;

                        if ($kode_surat && $letter_number) {
                            $combined_nomor_surat = $kode_surat . '/' . $letter_number . '/' . $roman_month . '/' . $year;
                            $set('letter_number', $combined_nomor_surat);
                        }
                    })

                    ->required(),  

                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->maxLength(255)
                    ->columnSpanFull(),

                
                    
                TextInput::make('place_of_birth')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->label('Tempat lahir')
                    ->maxLength(255)
                    ->columnSpanFull(),   

                DatePicker::make('date_of_birth')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->label('Tanggal lahir')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->maxDate(now())
                    ->columnSpanFull(),

                Select::make('nationality')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->label('Kewarganearaan')
                    ->options([
                        'indonesia' => 'Indonesia',
                        'wna' => 'WNA'
                        ])
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('id_number')
                    ->required()
                    ->label('NIK')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('jenis_kelamin')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->label('Jenis kelamin')
                    ->placeholder('Pilih opsi')
                    ->columnSpanFull()
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                        
                        ])
                    ->required(),

                Select::make('religion')
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

                    
                TextInput::make('nama_ibu_kandung')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->columnSpanFull(),

                TextInput::make('nomor_hp')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->columnSpanFull(),

                TextInput::make('domisili')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->default('Adalah benar penduduk yang berdomisili di ............')
                    ->columnSpanFull(),

                TextInput::make('selama')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->default('Berdasarkan sepengetahuan kami bahwa nama tersebut diatas adalah benar mempunya usaha bertani selama ... Tahun')
                    ->columnSpanFull(),

                Textarea::make('tujuan_surat')
                    ->label('Tujuan Surat')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->reactive()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->default('Adapun surat keterangan usaha ini dibuat untuk'),
                    
                
                TextInput::make('job')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->label('Pekerjaan')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('address')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->label('Tempat Tinggal')
                    ->maxLength(255)
                    ->columnSpanFull(),

                

                TextInput::make('kartu_keluarga')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '1' )
                    ->required()
                    ->label('Kartu Keluarga')
                    ->maxLength(255)
                    ->columnSpanFull(),


                TextInput::make('purpose')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->label('Keperluan')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('Tujuan')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->label('Tujuan')
                    ->maxLength(255)
                    ->columnSpanFull(),

                DatePicker::make('valid_from')
                    ->label('Berlaku mulai')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->maxDate(now())
                    ->columnSpanFull(),


                Select::make('template_remarks')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->label('Pilih Keterangan')
                    ->placeholder('Pilih opsi')
                    ->options([
                        'ORANG TERSEBUT BENAR-BENAR WARGA DESA KAMAL DAN BERADAT-ISTIADAT YANG BAIK' => 'ORANG TERSEBUT BENAR-BENAR WARGA DESA KAMAL DAN BERADAT-ISTIADAT YANG BAIK',
                        'ORANG TERSEBUT BENAR-BENAR WARGA DESA KAMAL' => 'ORANG TERSEBUT BENAR-BENAR WARGA DESA KAMAL',
                        'custom' => 'Custom',
                    ])
                    ->reactive()  
                    ->afterStateUpdated(function ($state, callable $set) {
                        
                        if ($state !== 'custom') {
                            $set('remarks', $state);
                        } else {
                            $set('remarks', $state);
                        }
                    })
                    ->required(),  // Ensure that something is always selected

                Textarea::make('remarks')
                    ->label('Keterangan lain-lain')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->visible(fn (Get $get) => $get('remarks') )  
                    ->reactive()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->placeholder('Masukkan keterangan secara manual jika memilih Custom.'),


                Select::make('jabatan')
                    ->label('Pilih Jabatan TTD')
                    ->columnSpanFull()
                    ->options([
                        'kepala_desa' => 'Kepala Desa Kamal',
                        'sekdes' => 'Sekretaris Desa',
                        'kaur_tu' => 'Kaur TU',
                    ])
                    ->required(),

                
            ]);

    }

    public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    
                    TextColumn::make('letter_number')
                        ->sortable()
                        ->label('Nomor surat')
                        ->searchable(),
                    TextColumn::make('name')
                        ->sortable()
                        ->label('Nama')
                        ->searchable(),
                    TextColumn::make('created_at')
                        ->sortable()
                        ->label('Tanggal Dibuat')
                        ->searchable()
                        ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)
                            ->locale('id') // Set locale to Indonesian
                            ->translatedFormat('d F Y')),
                    TextColumn::make('jenis.name')
                        ->sortable()
                        ->label('Jenis Surat')
                        ->searchable(),
                ])
                ->defaultSort('created_at', 'desc')
                ->filters([
                    Tables\Filters\SelectFilter::make('jenis_id')
                        ->relationship('jenis', 'name'),
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
                            return redirect()->route('export.suratPengantarByMonth', ['month' => $data['month']]);
                        })
                        ->icon('heroicon-o-arrow-down-tray'),
                ])

                ->actions([
                    
                    // View PDF action
                    // Action::make('viewPDF')
                    //     ->label('View PDF')
                    //     ->tooltip('View this letter as a PDF')
                    //     ->url(fn (Surat $record) => route('view.letter', ['id' => $record->id]))
                    //     ->icon('heroicon-o-eye')
                    //     ->openUrlInNewTab(),
                    
                    // Download PDF action
                    Action::make('downloadPDF')
                    ->label('Download PDF')
                    ->url(fn (Surat $record) => route('download.letter', ['id' => $record->id]))
                    ->icon('heroicon-o-arrow-down-tray'),
                    
                   
                    Tables\Actions\EditAction::make(),
                    
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurats::route('/'),
            'create' => Pages\CreateSurat::route('/create'),
            'edit' => Pages\EditSurat::route('/{record}/edit'),
        ];
    }
}
