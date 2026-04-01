<?php

namespace App\Filament\Resources\SurveyResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SurveyResponsesRelationManager extends RelationManager
{
    protected static string $relationship = 'surveyResponses';

    public function form(Schema $form): Schema
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('surveyhero_id')
                    ->label('Surveyhero ID')
                    ->sortable(),
                TextColumn::make('survey_language')
                    ->label('Language')
                    ->sortable(),
                IconColumn::make('survey_completed')
                    ->label('Completed')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('survey_start_date')
                    ->label('Started')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('survey_last_updated')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('survey_start_date', 'desc')
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
