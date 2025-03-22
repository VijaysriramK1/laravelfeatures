<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadIntegrationResource\Pages;
use App\Filament\Resources\LeadIntegrationResource\RelationManagers;
use App\Models\LeadIntegration;
use App\SmSetupAdmin;
use App\SmStaff;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadIntegrationResource extends Resource
{
    protected static ?string $model = SmSetupAdmin::class;

    protected static ?string $navigationGroup = 'Admission Section';

    protected static ?string $navigationLabel = 'Lead Integration';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Lead Integration')
                    ->schema([
                        Section::make('General')
                            ->columns(2)
                            ->schema([
                                Select::make('source')
                                    ->label('Source')
                                    ->options(
                                        SmSetupAdmin::where('type', 3)->pluck('name', 'id')->toArray()
                                    ),
                                Select::make('status')
                                    ->options([
                                        'Complete' => 'Complete',
                                        'Pending' => 'Pending',
                                    ]),
                                select::make('Assigned (Responsible)')
                                    ->options([
                                        SmStaff::all()->pluck('full_name', 'id')->toArray()
                                    ])
                            ]),
                        Section::make('Integration Code')
                            ->columns(2)
                            ->schema([
                                Toggle::make('is_admin')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->helperText('Enable/Disable Form Display On Contact Page'),
                                Textarea::make('iframe_code')
                                    ->helperText('Copy & Paste the code anywhere in your site to show the form. You can also adjust the width and height to fit your website.')
                                    ->default('<iframe id="iframe" src="https://sgacademy.betelgeusetech.com/lead-integration/lead-form" style="width: 100%; height: 400px; border: 1px solid #ddd;"></iframe>'),
                                TextInput::make('Share Link With Anyone')
                                    ->default('https://sgacademy.betelgeusetech.com/lead-integration/lead-form')->columnSpanFull(),
                            ]),
                            
                        Section::make('Source')
                            ->schema([
                                TextInput::make('name'),
                            ]),
                        Section::make('Status')
                            ->schema([
                               TextInput::make('status')
                            ])
                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeadIntegrations::route('/'),
            'create' => Pages\CreateLeadIntegration::route('/create'),
            'edit' => Pages\EditLeadIntegration::route('/{record}/edit'),
        ];
    }
}
