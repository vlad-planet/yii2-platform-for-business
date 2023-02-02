<?php

use yii\db\Migration;

/**
 * Таблица "Сотрудники акта"
 *
 * Handles the creation of table `{{%act_employees}}`.
 *
 * @author Vladislav Bashlykov
 */
class m220423_164154_create_act_employees_table extends Migration
{
	public const TABLE_NAME = 'act_employees';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TABLE_NAME, [
            'id'				 => 'uuid DEFAULT uuid_generate_v4() unique',
			'fio'				 => $this->string(255)->notNull()->comment('ФИО сотрудника'),
			'position'			 => $this->string(255)->notNull()->comment('Должность'),
			'department'		 => $this->string(255)->notNull()->comment('Подразделение'),
			'date_create'		 => $this->timestamp()->notNull()->defaultExpression('now()')->comment('Дата создания'),
			'act_id'			 => 'uuid',
			'salary'			 => $this->integer()->notNull()->comment('Зарплата'),
			'rate'				 => $this->decimal()->notNull()->comment('Ставка зарплаты'),
			'phone'				 => $this->string(255)->comment('Телефон'),
			'email'				 => $this->string(255)->comment('Email'),
			'hire_date'			 => $this->date()->notNull()->comment('Дата приёма на работу'),
			'manager'			 => 'uuid',
			'bonus_avaible'		 => $this->tinyInteger()->defaultValue(0)->comment('Наличие премии (0 - нет; 1 - да)'),
			'phone_compensation' => $this->tinyInteger()->defaultValue(0)->comment('Компенсация мобильной связи (0 - нет; 1 - да)'),
			'dms'				 => $this->tinyInteger()->defaultValue(0)->comment('ДМС (0 - нет; 1 - да)'),
        ]);
				
		$this->addCommentOnTable(static::TABLE_NAME, 'Сотрудники акта');
		
		$this->addPrimaryKey(static::TABLE_NAME . '_id-pk', static::TABLE_NAME, 'id');
		
		$this->addCommentOnColumn(static::TABLE_NAME, 'id', 'ID записи');
		$this->addCommentOnColumn(static::TABLE_NAME, 'act_id', 'ID акта');
		$this->addCommentOnColumn(static::TABLE_NAME, 'manager', 'ID руководителя');
		
		$this->addForeignKey(static::TABLE_NAME . '_act_id-user_acts', static::TABLE_NAME, 'act_id', 'user_acts', 'id');
		$this->addForeignKey(static::TABLE_NAME . '_manager-act_employees', static::TABLE_NAME, 'manager', 'act_employees', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(static::TABLE_NAME);
    }
}
