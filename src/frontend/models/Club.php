<?php

namespace frontend\models;

use common\behaviors\SoftDeleteBehavior;
use common\models\queries\SoftDeleteQuery;
use common\models\User;
use common\traits\BlameableRelationsTrait;
use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "club".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property ClientClub[] $clientClubs
 * @property Client[] $clients
 */
class Club extends ActiveRecord
{

    use BlameableRelationsTrait;

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
        return 'club';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['address', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'default', 'value' => null],
            [['name'], 'required'],
            [['address'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
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
     * Gets query for [[ClientClubs]].
     *
     * @return ActiveQuery
     */
    public function getClientClubs(): ActiveQuery
    {
        return $this->hasMany(ClientClub::class, ['club_id' => 'id']);
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getClients(): ActiveQuery
    {
        return $this->hasMany(Client::class, ['id' => 'client_id'])->viaTable('client_club', ['club_id' => 'id']);
    }
}
