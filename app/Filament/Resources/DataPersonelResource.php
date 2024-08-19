<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPersonelResource\Pages;
use App\Filament\Resources\DataPersonelResource\RelationManagers;
use App\Filament\Resources\DataPersonelResource\Widgets\DataPersonelStats;
use App\Models\DataPersonel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataPersonelResource extends Resource
{
    protected static ?string $model = DataPersonel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pangkat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('korp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nrp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('satker')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('baju_pdh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('celana_pdh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pdh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('baju_pdu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('celana_pdu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pdu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pdl')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nrp')
                    ->label('NRP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pangkat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('korp')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('satker')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jk')
                    ->label('JK')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('baju_pdh')
                    ->label('Baju PDH')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('celana_pdh')
                    ->label('Celana PDH')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pdh')
                    ->label('PDH')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('baju_pdu')
                    ->label('Baju PDU')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('celana_pdu')
                    ->label('Celana PDU')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pdu')
                    ->label('PDU')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pdl')
                    ->label('PDL')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getWidgets(): array
    {
        return [
            DataPersonelStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPersonels::route('/'),
            'create' => Pages\CreateDataPersonel::route('/create'),
            'edit' => Pages\EditDataPersonel::route('/{record}/edit'),
        ];
    }
}
