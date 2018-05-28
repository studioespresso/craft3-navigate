<?php
/**
 * Navigate plugin for Craft CMS 3.x
 *
 * Navigation plugin for Craft 3
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 Studio Espresso
 */

namespace studioespresso\navigate\models;

use craft\validators\HandleValidator;
use studioespresso\navigate\Navigate;

use Craft;
use craft\base\Model;
use yii\bootstrap\Nav;

/**
 * Navigate Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Studio Espresso
 * @package   Navigate
 * @since     0.0.1
 */
class NavigationModel extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $id;

    public $title;

    public $handle;

    public $defaultNodeType = 'entry';

    public $allowedSources = '*';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'handle', 'defaultNodeType', 'allowedSources'], 'required'],
            [['title', 'handle', 'defaultNodeType', 'allowedSources'], 'safe'],
            ['handle', 'validateHandle'],
        ];
    }

    public function validateHandle() {

        $validator = new HandleValidator();
        $validator->validateAttribute($this, 'handle');

        if(Navigate::$plugin->navigate->getNavigationByHandle($this->handle)) {
            $this->addError('handle', Craft::t('navigate', 'Handle "{handle}" has already been taken', ['handle' => $this->handle]));
        }

    }
}