<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratUsahaResource\Pages;
use App\Filament\Resources\SuratUsahaResource\RelationManagers;
use App\Models\surat_keterangan_usaha;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;

class SuratUsahaResource extends Resource
{
    protected static ?string $model = surat_keterangan_usaha::class;
    protected static ?string $navigationGroup = 'Surat-surat';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralLabel(): string
    {
        return 'Surat Keterangan Usaha';  
    }

    public static function getLabel(): string
    {
        return 'Surat Keterangan Usaha'; 
    }

     public static function slug(): string
    {

        return 'surat-keterangan-usaha'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        
                // Select::make('jenis_id')
                //     ->relationship('jenis', 'name')
                //     ->label('Jenis Surat')
                //     ->placeholder('Pilih opsi')
                //     ->required()
                //     ->columnSpanFull()
                //     ->live(),
                    
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
                    ->hint('Nomor surat terakhir: ' . surat_keterangan_usaha::latest('created_at')->value('letter_number'))
                    ->required(),  

                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->maxLength(255)
                    ->columnSpanFull(),

                

                TextInput::make('id_number')
                    ->required()
                    ->label('NIK')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('jenis_kelamin')
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
                    ->columnSpanFull(),

                TextInput::make('nomor_hp')
                    ->columnSpanFull(),

                TextInput::make('domisili')
                    ->default('Adalah benar penduduk yang berdomisili di ............')
                    ->columnSpanFull(),

                TextInput::make('selama')
                    ->default('Berdasarkan sepengetahuan kami bahwa nama tersebut diatas adalah benar mempunyai usaha ....... selama ... Tahun')
                    ->columnSpanFull(),

                Textarea::make('tujuan_surat')
                    ->label('Tujuan Surat')
                    ->reactive()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->default('Adapun surat keterangan usaha ini dibuat untuk ........'),
                    
                
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
                            return redirect()->route('export.suratUsahaByMonth', ['month' => $data['month']]);
                        })
                        ->icon('heroicon-o-arrow-down-tray'),
                ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('downloadPDF')
                    ->label('Download PDF')
                    ->url(fn (surat_keterangan_usaha $record) => route('download.usaha', ['id' => $record->id]))
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
            'index' => Pages\ListSuratUsahas::route('/'),
            'create' => Pages\CreateSuratUsaha::route('/create'),
            'edit' => Pages\EditSuratUsaha::route('/{record}/edit'),
        ];
    }
}
