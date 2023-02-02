<?php

namespace common\models\queries;

use common\models\db\Auth;
use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[Auth]].
 *
 * @see Auth
 *
 * @author Vladislav Bashlykov
 */
class AuthQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Auth[]|array
     *
     * @author Vladislav Bashlykov
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Auth|array|null
     *
     * @author Vladislav Bashlykov
     */
    public function one($db = null): Auth|array|null
    {
        return parent::one($db);
    }
}
