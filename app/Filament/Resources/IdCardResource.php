<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdCardResource\Pages;
use App\Models\SmStudentIdCard;
use App\SmStudentIdCard as AppSmStudentIdCard;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IdCardResource extends Resource
{
    protected static ?string $model = AppSmStudentIdCard::class;
    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'ID Card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('ID Card Configuration')
                    ->schema([
                      
                        TextInput::make('title')
                            ->label('ID Card Title')
                            ->required()
                            ->live(),

                        Select::make('admin.layout')
                            ->label('Admin.layout')
                            ->options([
                                'Horizontal' => 'Horizontal',
                                'Vertical' => 'Vertical',

                            ])
                            ->required()
                            ->live(),

                        FileUpload::make('Background Image')->label('Background Image')->live(),

                        Select::make('applicableUser')
                            ->label('Applicable User')
                            ->options([
                                'student' => 'Student',
                                'parent' => 'Parent',
                                'teacher' => 'Teacher',
                                'employee' => 'Employee',
                                'admin' => 'Admin',
                                'staff' => 'Staff',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->live(),

                        // Layout Configuration
                        Section::make('Layout Settings')
                            ->columns(2)
                            ->schema([
                                TextInput::make('pageLayoutWidth')
                                    ->label('Page Width (mm)')
                                    ->default(57)
                                    ->numeric()
                                    ->live()
                                    ->rules(['min:30', 'max:200']),

                                TextInput::make('pageLayoutHeight')
                                    ->label('Page Height (mm)')
                                    ->default(89)
                                    ->numeric()
                                    ->live()
                                    ->rules(['min:50', 'max:300']),

                            ]),

                      
                        FileUpload::make('profileImage')
                            ->label('Profile Image')
                            ->image()
                            ->live(),

                        Select::make('userPhotoStyle')
                            ->label('User Photo Style')
                            ->options([
                                'square' => 'Square',
                                'circle' => 'Circle',
                            ])
                            ->default('circle')
                            ->live(),

                            Section::make('Photo Size')
                            ->columns(2)
                            ->schema([
                                TextInput::make('User Photo Size Width (Default 21 mm)')
                                    ->label('User Photo Size Width')
                                    ->default(21)
                                    ->numeric()
                                    ->live(),

                                TextInput::make('User Photo Size hieght (Default 21 mm)')
                                    ->label('User Photo Size hieght')
                                    ->default(21)
                                    ->numeric()
                                    ->live(),
                            ]),

                        Section::make('Layout Spacing')
                            ->columns(2)
                            ->schema([
                                TextInput::make('TopSpace')
                                    ->label('Left Space (mm)')
                                    ->default(2.5)
                                    ->numeric()
                                    ->live(),

                                TextInput::make('BottomSpace')
                                    ->label('Left Space (mm)')
                                    ->default(2.5)
                                    ->numeric()
                                    ->live(),

                                TextInput::make('topSpace')
                                    ->label('Top Space (mm)')
                                    ->default(2.5)
                                    ->numeric()
                                    ->live(),

                                TextInput::make('leftSpace')
                                    ->label('Left Space (mm)')
                                    ->default(2.5)
                                    ->numeric()
                                    ->live(),

                            ]),
                        FileUpload::make('logo')
                            ->label('Institution Logo')
                            ->image()
                            ->live(),

                        FileUpload::make('Signature')
                            ->label('Signature')
                            ->image()
                            ->live(),

                        Section::make('Visible Fields')
                            ->columns(2)
                            ->schema([
                                Radio::make('admissionNo')
                                    ->label('Admission No ')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('name')
                                    ->label('Name')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('class')
                                    ->label('Class')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('fatherName')
                                    ->label('Father Name')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('motherName')
                                    ->label('Mother Name')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('address')
                                    ->label('Address')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('dateOfBirth')
                                    ->label('Date of Birth')
                                    ->boolean()
                                    ->inline()
                                    ->live(),

                                Radio::make('bloodGroup')
                                    ->label('Blood Group')
                                    ->boolean()
                                    ->inline()
                                    ->live(),
                            ]),
                    ])
                    ->columnSpan(1),


                Section::make('ID Card Preview')
                    ->schema([
                        \Filament\Forms\Components\View::make('id-card.preview')
                            ->label(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(2);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('title')->label('Title'),
                TextColumn::make('applicableUser')->label('User Type'),
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
            'index' => Pages\ListIdCards::route('/'),
            'create' => Pages\CreateIdCard::route('/create'),
            'edit' => Pages\EditIdCard::route('/{record}/edit'),
        ];
    }
}
