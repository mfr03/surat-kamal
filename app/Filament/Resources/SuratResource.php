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


class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        
                Select::make('jenis_id')
                    ->relationship('jenis', 'name')
                    ->label('Jenis Surat')
                    ->required()
                    ->columnSpanFull()
                    ->live(),
                    
                    Select::make('kode_surat')
                        // ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                        ->label('Kode Surat')
                        ->columnSpan(1)
                        ->options([
                            '430' => '430 - Umum',
                            '300' => '300 - Bank'
                            ])
                        ->required(),

                TextInput::make('letter_number')
                    ->required()
                    ->label('Nomor Surat')
                    ->maxLength(255)
                    ->columnSpan(1),

                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                TextInput::make('nama_ibu_kandung')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->columnSpanFull(),

                TextInput::make('nomor_hp')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
                    ->columnSpanFull(),

                TextInput::make('keterangan_usaha')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '2')
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

                Select::make('religion')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                ->label('Agama')
                ->options([
                    'islam' => 'Islam',
                    'christianity' => 'Kristen',
                    'hinduism' => 'Hindu',
                    'buddhism' => 'Budha',
                    'konghucu' => 'Konghucu',
                    ])
                    ->required()
                    ->columnSpanFull(),

                    

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

                TextInput::make('id_number')
                    ->visible(fn (Get $get): bool => $get('jenis_id') === '1' || '2')
                    ->required()
                    ->label('NIK')
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
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->maxDate(now())
                    ->columnSpanFull(),

                DatePicker::make('valid_until')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->required()
                    ->columnSpanFull(),
                    
                Textarea::make('remarks')
                ->visible(fn (Get $get): bool => $get('jenis_id') === '1')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
            ]);

    }

    public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    
                    TextColumn::make('id')
                        ->sortable()
                        ->label('No'),
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
                        ->searchable(),
                    TextColumn::make('jenis.name')
                        ->sortable()
                        ->label('Jenis Surat')
                        ->searchable(),
                ])
                ->filters([
                    Tables\Filters\SelectFilter::make('jenis_id')
                        ->relationship('jenis', 'name'),
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
