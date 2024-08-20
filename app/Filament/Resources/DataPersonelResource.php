<?php

namespace App\Filament\Resources;

use App\Exports\DataPersonelExport;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataPersonel;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataPersonelResource\Pages;
use App\Filament\Resources\DataPersonelResource\RelationManagers;
use App\Filament\Resources\DataPersonelResource\Widgets\DataPersonelStats;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
                Tables\Columns\IconColumn::make('is_selected')
                    ->label('Status')
                    ->boolean()
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
                Tables\Filters\Filter::make('Status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'filled' => 'Terisi',
                                'empty' => 'Tidak Terisi',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                isset($data['status']) && $data['status'] === 'filled',
                                fn(Builder $query): Builder => $query->where(function (Builder $query) {
                                    $query->whereNotNull('baju_pdh')
                                        ->orWhereNotNull('celana_pdh')
                                        ->orWhereNotNull('pdh')
                                        ->orWhereNotNull('baju_pdu')
                                        ->orWhereNotNull('celana_pdu')
                                        ->orWhereNotNull('pdu')
                                        ->orWhereNotNull('pdl');
                                })
                            )
                            ->when(
                                isset($data['status']) && $data['status'] === 'empty',
                                fn(Builder $query): Builder => $query->whereNull('baju_pdh')
                                    ->whereNull('celana_pdh')
                                    ->whereNull('pdh')
                                    ->whereNull('baju_pdu')
                                    ->whereNull('celana_pdu')
                                    ->whereNull('pdu')
                                    ->whereNull('pdl')
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if (!empty($data['status'])) {
                            $indicators['status'] = $data['status'] === 'filled' ? 'Status: Terisi' : 'Status: Tidak Terisi';
                        }
                        return $indicators;
                    }),

                Tables\Filters\Filter::make('Duplicate NRP')
                    ->form([
                        Forms\Components\Checkbox::make('duplicate_nrp')
                            ->label('Tampilkan hanya NRP duplikat')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['duplicate_nrp'] ?? false, function ($query) {
                            $query->whereIn('nrp', function ($subQuery) {
                                $subQuery->select('nrp')
                                    ->from('data_personels')
                                    ->groupBy('nrp')
                                    ->havingRaw('COUNT(*) > 1');
                            });
                        });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if (!empty($data['duplicate_nrp'])) {
                            $indicators['duplicate_nrp'] = 'NRP: Duplikat';
                        }
                        return $indicators;
                    }),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groups([
                Group::make('nrp')
                    ->label('NRP')
                    ->collapsible(),
                Group::make('pangkat')
                    ->collapsible(),
            ])
            ->groupingSettingsInDropdownOnDesktop()
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Selected yang dipilih')
                        ->requiresConfirmation()
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_selected' => true,
                                ]);
                            }

                            Notification::make()
                                ->title('Data yang dipilih berhasil di Selected')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('Batalkan yang dipilih')
                        ->requiresConfirmation()
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_selected' => false,
                                ]);
                            }

                            Notification::make()
                                ->title('Data yang dipilih berhasil di atalkan')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    ExportBulkAction::make()
                        ->label('Eksport data yang dipilih'),
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
