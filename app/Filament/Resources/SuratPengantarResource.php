<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratPengantarResource\Pages;
use App\Filament\Resources\SuratPengantarResource\RelationManagers;
use App\Models\surat_pengantar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components;

class SuratPengantarResource extends Resource
{
    protected static ?string $model = surat_pengantar::class;

    protected static ?string $navigationGroup = 'Surat-surat';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralLabel(): string
    {
        return 'Surat Pengantar';  
    }

    public static function getLabel(): string
    {
        return 'Surat Pengantar'; 
    }

     public static function slug(): string
    {
        return 'surat-pengantar'; 
    }
    

    



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    
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
                    ->reactive(),

                TextInput::make('nomor_surat')
                    ->label('Nomor')
                    ->maxLength(255)
                    ->columnSpan(1)
                    ->required()
                    ->reactive(), 

                TextInput::make('letter_number')
                    ->label('Nomor Surat')
                    ->columnSpanFull()
                    ->reactive()  
                    ->afterStateUpdated(function ($state, callable $set, Get $get) {
                        $kode_surat = $get('kode_surat');
                        $letter_number = $get('nomor_surat');
                        
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
                    ->hint('Nomor surat terakhir: ' . surat_pengantar::latest('created_at')->value('letter_number'))
                    ->required(),  

                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->maxLength(255)
                    ->columnSpanFull(),

                
                    
                TextInput::make('place_of_birth')
                    ->required()
                    ->label('Tempat lahir')
                    ->maxLength(255)
                    ->columnSpanFull(),   

                DatePicker::make('date_of_birth')
                    ->required()
                    ->label('Tanggal lahir')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->maxDate(now())
                    ->columnSpanFull(),

                Select::make('nationality')
                    ->label('Kewarganearaan')
                    ->options([
                        'indonesia' => 'Indonesia',
                        'wna' => 'WNA'
                        ])
                    ->required()
                    ->columnSpanFull(),

                 
                TextInput::make('job')
                    ->required()
                    ->label('Pekerjaan')
                    ->maxLength(255)
                    ->columnSpanFull(),
                

                TextInput::make('address')
                    ->required()
                    ->label('Tempat Tinggal')
                    ->maxLength(255)
                    ->columnSpanFull(),

               
                TextInput::make('id_number')
                    ->required()
                    ->label('NIK')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('kartu_keluarga')
                    ->required()
                    ->label('Kartu Keluarga')
                    ->maxLength(255)
                    ->columnSpanFull(),


                TextInput::make('purpose')
                    ->required()
                    ->label('Keperluan')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('Tujuan')
                    ->required()
                    ->label('Tujuan')
                    ->maxLength(255)
                    ->columnSpanFull(),

                DatePicker::make('valid_from')
                    ->label('Berlaku mulai')
                    ->required()
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->maxDate(now())
                    ->columnSpanFull(),


                Select::make('template_remarks')
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
                ])
                ->defaultSort('created_at', 'desc')
                ->filters([
                  
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
                    
                    Tables\Actions\EditAction::make(),

                    // Download PDF action
                    Action::make('downloadPDF')
                    ->label('Download PDF')
                    ->url(fn (surat_pengantar $record) => route('download.pengantar', ['id' => $record->id]))
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratPengantars::route('/'),
            'create' => Pages\CreateSuratPengantar::route('/create'),
            'edit' => Pages\EditSuratPengantar::route('/{record}/edit'),
        ];
    }
}
