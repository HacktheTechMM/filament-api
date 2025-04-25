<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Filament\Actions\Exports\Enums\ExportFormat;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('John Doe'),
                TextInput::make('email')
                    ->required()
                    ->placeholder('johndoe@example.com'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->placeholder('Enter password')
                    ->visibleOn('create'),
                Select::make('role')
                    ->options(User::ROLES),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(),
                TextColumn::make('name')
                    ->sortable()->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->sortable()->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role')
                    ->color(function (string $state): string {
                        return match ($state) {
                            'ADMIN' => 'danger',
                            'EDITOR' => 'info',
                            'USER' => 'success',
                            'LEARNER' => 'gray',
                            'MENTOR' => 'warning',
                        };
                    })
                    ->badge()->sortable()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                // ExportAction::make()
                //     ->exporter(UserExporter::class)
                //     ->formats([
                //         ExportFormat::Csv
                //     ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                // ExportBulkAction::make()
                //     ->exporter(UserExporter::class)
                //     ->formats([
                //         ExportFormat::Csv
                //     ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
