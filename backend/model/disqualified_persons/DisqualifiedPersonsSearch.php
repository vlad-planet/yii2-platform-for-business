<?php

namespace backend\models\disqualified_persons;

use common\models\db\DisqualifiedPersons;
use common\yii\validators\DateValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Поисковая модель для [[\common\models\db\DisqualifiedPersons]].
 *
 * Class DisqualifiedPersonsSearch
 * @package backend\models\disqualified_persons
 *
 * @author Vladislav Bashlykov
 */
class DisqualifiedPersonsSearch extends Model
{
    /** @var string */
    public $number_in_reestr;
    const ATTR_NUMBER_IN_REESTR = 'number_in_reestr';

    /** @var string */
    public $fio;
    const ATTR_FIO = 'fio';

    /** @var string */
    public $b_day;
    const ATTR_B_DAY = 'b_day';

    /** @var string */
    public $b_place;
    const ATTR_B_PLACE = 'b_place';

    /** @var string */
    public $company;
    const ATTR_COMPANY = 'company';

    /** @var string */
    public $inn;
    const ATTR_INN = 'inn';

    /** @var string */
    public $position;
    const ATTR_POSITION = 'position';

    /** @var string */
    public $article_code;
    const ATTR_ARTICLE_CODE = 'article_code';

    /** @var string */
    public $body_title;
    const ATTR_BODY_TITLE = 'body_title';

    /** @var string */
    public $judge_fio;
    const ATTR_JUDGE_FIO = 'judge_fio';

    /** @var string */
    public $judge_position;
    const ATTR_JUDGE_POSITION = 'judge_position';

    /** @var string */
    public $date_start;
    const ATTR_DATE_START = 'date_start';

    /** @var string */
    public $date_end;
    const ATTR_DATE_END = 'date_end';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /**
     * Правила валидации данных
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function rules(): array
    {
        return [
            [static::ATTR_NUMBER_IN_REESTR, TrimValidator::class],
            [static::ATTR_NUMBER_IN_REESTR, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_FIO, TrimValidator::class],
            [static::ATTR_FIO, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_B_DAY, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],

            [static::ATTR_B_PLACE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_COMPANY, TrimValidator::class],
            [static::ATTR_COMPANY, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_INN, TrimValidator::class],
            [static::ATTR_INN, StringValidator::class],
            [static::ATTR_INN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_POSITION, TrimValidator::class],
            [static::ATTR_POSITION, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_ARTICLE_CODE, TrimValidator::class],
            [static::ATTR_ARTICLE_CODE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_BODY_TITLE, TrimValidator::class],
            [static::ATTR_BODY_TITLE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_JUDGE_FIO, TrimValidator::class],
            [static::ATTR_JUDGE_FIO, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_JUDGE_POSITION, TrimValidator::class],
            [static::ATTR_JUDGE_POSITION, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_DATE_START, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],

            [static::ATTR_DATE_END, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],
        ];
    }

    /**
     * Сценарии
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function formName(): string
    {
        return '';
    }

    /**
     * Поиск по фильтру
     *
     * @param array $params
     * @return ActiveDataProvider
     *
     * @author Vladislav Bashlykov
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DisqualifiedPersons::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (true === $this->validate()) {
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_NUMBER_IN_REESTR, $this->number_in_reestr]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_FIO, $this->fio]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . DisqualifiedPersons::ATTR_B_DAY, $this->b_day. ' AS text)'), $this->b_day]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_B_PLACE, $this->b_place]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_COMPANY, $this->company]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_INN, $this->inn]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_POSITION, $this->position]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_ARTICLE_CODE, $this->article_code]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_BODY_TITLE, $this->body_title]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_JUDGE_FIO, $this->judge_fio]);
            $query->andFilterWhere(['ilike', DisqualifiedPersons::ATTR_JUDGE_POSITION, $this->judge_position]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . DisqualifiedPersons::ATTR_DATE_START, $this->date_start. ' AS text)'), $this->date_start]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . DisqualifiedPersons::ATTR_DATE_END, $this->date_end. ' AS text)'), $this->date_end]);

            $query->andFilterWhere(['ilike', new Expression('CAST(' . DisqualifiedPersons::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
        }

        return $dataProvider;
    }
}