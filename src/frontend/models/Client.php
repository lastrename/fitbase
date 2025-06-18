<?php

namespace frontend\models;

use common\behaviors\SoftDeleteBehavior;
use common\models\queries\SoftDeleteQuery;
use common\traits\BlameableRelationsTrait;
use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $full_name
 * @property string $gender
 * @property string $birth_date
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property ClientClub[] $clientClubs
 * @property Club[] $clubs
 */
class Client extends ActiveRecord
{

    use BlameableRelationsTrait;

    public array $club_ids = [];

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => SoftDeleteBehavior::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'default', 'value' => null],
            [['full_name', 'gender', 'club_ids'], 'required'],
            [['birth_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['full_name'], 'string', 'max' => 255],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            ['club_ids', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'club_ids' => 'Clubs',
        ];
    }

    /**
     * @return SoftDeleteQuery
     */
    public static function find(): SoftDeleteQuery
    {
        return new SoftDeleteQuery(static::class);
    }

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function afterFind(): void
    {
        parent::afterFind();
        $this->club_ids = $this->getClubs()->select('id')->column();
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        $this->unlinkAll('clubs', true);
        if (!empty($this->club_ids)) {
            foreach ($this->club_ids as $clubId) {
                $this->link('clubs', Club::findOne($clubId));
            }
        }
    }

    /**
     * @return string[]
     */
    public static function getGenderOptions(): array
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        ];
    }

    /**
     * Gets query for [[ClientClubs]].
     *
     * @return ActiveQuery
     */
    public function getClientClubs(): ActiveQuery
    {
        return $this->hasMany(ClientClub::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Clubs]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getClubs(): ActiveQuery
    {
        return $this->hasMany(Club::class, ['id' => 'club_id'])->viaTable('client_club', ['client_id' => 'id']);
    }
}
