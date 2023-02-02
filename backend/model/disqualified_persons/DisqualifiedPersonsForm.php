<?php

namespace backend\models\disqualified_persons;

use common\models\db\DisqualifiedPersons;
use common\yii\validators\DateValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;

/**
 * Модель данных для формы 'Реестр дисквалифицированных лиц'
 *
 * Class DisqualifiedPersonsForm
 * @package backend\models\disqualified_persons
 *
 * @author Vladislav Bashlykov
 */
class DisqualifiedPersonsForm extends Model
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

    /** @var DisqualifiedPersons  */
    public $_model;

    /**
     * При инициализации класса
     *
     * @param DisqualifiedPersons|null $model
     * @param array $config
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(DisqualifiedPersons $model = null, array $config = [])
    {
        if (null !== $model) {
            $this->number_in_reestr = $model->number_in_reestr;
            $this->fio              = $model->fio;
            $this->b_day            = $model->b_day;
            $this->b_place          = $model->b_place;
            $this->company          = $model->company;
            $this->inn              = $model->inn;
            $this->position         = $model->position;
            $this->article_code     = $model->article_code;
            $this->body_title       = $model->body_title;
            $this->judge_position   = $model->judge_position;
            $this->judge_fio        = $model->judge_fio;
            $this->date_start       = $model->date_start;
            $this->date_end         = $model->date_end;

            $this->_model  = $model;
        }

        parent::__construct($config);
    }

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
            [static::ATTR_NUMBER_IN_REESTR, RequiredValidator::class],
            [static::ATTR_NUMBER_IN_REESTR, TrimValidator::class],
            [static::ATTR_NUMBER_IN_REESTR, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_FIO, RequiredValidator::class],
            [static::ATTR_FIO, TrimValidator::class],
            [static::ATTR_FIO, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_B_DAY, RequiredValidator::class],
            [static::ATTR_B_DAY, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],

            [static::ATTR_B_PLACE, RequiredValidator::class],
            [static::ATTR_B_PLACE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_COMPANY, RequiredValidator::class],
            [static::ATTR_COMPANY, TrimValidator::class],
            [static::ATTR_COMPANY, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_INN, TrimValidator::class],
            [static::ATTR_INN, StringValidator::class],
            [static::ATTR_INN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_POSITION, RequiredValidator::class],
            [static::ATTR_POSITION, TrimValidator::class],
            [static::ATTR_POSITION, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_ARTICLE_CODE, RequiredValidator::class],
            [static::ATTR_ARTICLE_CODE, TrimValidator::class],
            [static::ATTR_ARTICLE_CODE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_BODY_TITLE, RequiredValidator::class],
            [static::ATTR_BODY_TITLE, TrimValidator::class],
            [static::ATTR_BODY_TITLE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_JUDGE_FIO, RequiredValidator::class],
            [static::ATTR_JUDGE_FIO, TrimValidator::class],
            [static::ATTR_JUDGE_FIO, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_JUDGE_POSITION, RequiredValidator::class],
            [static::ATTR_JUDGE_POSITION, TrimValidator::class],
            [static::ATTR_JUDGE_POSITION, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_DATE_START, RequiredValidator::class],
            [static::ATTR_DATE_START, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],

            [static::ATTR_DATE_END, RequiredValidator::class],
            [static::ATTR_DATE_END, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],
        ];
    }

    /**
     * Наименование атрибутов
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_NUMBER_IN_REESTR => 'Номер записи РДЛ',
            static::ATTR_FIO              => 'ФИО',
            static::ATTR_B_DAY            => 'День рождения',
            static::ATTR_B_PLACE          => 'Место рождения',
            static::ATTR_COMPANY          => 'Организация',
            static::ATTR_INN              => 'ИНН',
            static::ATTR_POSITION         => 'Должность',
            static::ATTR_ARTICLE_CODE     => 'Статья КоАП РФ',
            static::ATTR_BODY_TITLE       => 'Наименование органа, составившего протокол об административном правонарушении',
            static::ATTR_JUDGE_FIO        => 'ФИО судьи',
            static::ATTR_JUDGE_POSITION   => 'Должность судьи',
            static::ATTR_DATE_START       => 'Дата начала дисквалификации',
            static::ATTR_DATE_END         => 'Дата истечения срока дисквалификации',
        ];
    }

    /**
     * Сохранение данных в БД
     *
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $newsService = new DisqualifiedPersonsService($this);
            $result = $newsService->save();
        }

        return $result;
    }
}