<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
use App\SmStudentCertificate;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificateResource extends Resource
{
    protected static ?string $model = SmStudentCertificate::class;

    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'Certificate';

  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Certificate Name')->required(),
                TextInput::make('header_left_text')->label('Header left text'),
                DatePicker::make('date')->label('Date'),
                Select::make('body_font_family')
                ->options([
                    'Arial' => 'Arial',
                    'Arial Black' => 'Arial Black',
                    'Pinyon Script' => 'Pinyon Script',
                    'Comic Sans MS' => 'Comic Sans MS',
                   
                    ]),

                TextInput::make('body')
                ->label('Body (Max Character length 500)')
                ->maxLength(500)  
                ->helperText('[name] [dob] [present_address] [guardian] [created_at] [admission_no] [roll_no] [gender] [admission_date] [category] [cast] [father_name] [mother_name] [religion] [email] [phone] [class] [section]')->columnSpanFull(),
                    TextInput::make('body_font_size')->label('Font Size')->required(),
                    TextInput::make('footer_left_text')->label('Footer left text'),
                    TextInput::make('footer_center_text')->label('Footer Center text'),
                    TextInput::make('footer_right_text')->label('Footer Right text'),
                    Select::make('layout')
                    ->options([
                        'A4(Portraint)' => 'A4(Portraint)',
                        'A4(Landscape)' => 'A4(Landscape)',
                        'Custom' => 'Custom',
                    ])
                    ->required(),
                    TextInput::make('width')->label('Width')->required(),
                    TextInput::make('height')->label('Height')->required()->columnSpanFull(),
                    Radio::make('student_photo')
                    ->label('Student Photo')
                    ->boolean()
                    ->inline()
                    ->live(),
                    FileUpload::make('file')->label('Background Image')->default('image(1100 X 850)px*')->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                ImageColumn::make('file')->label('Background Image'),
                TextColumn::make('default_for')->label('Default For'),
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
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
