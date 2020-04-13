<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page.php';
    include_once dirname(__FILE__) . '/' . 'components/page/detail_page.php';
    include_once dirname(__FILE__) . '/' . 'components/page/nested_form_page.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class cmd_autoPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cmd_auto`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_cmdauto', true, true, true),
                    new StringField('cmd_auto', true),
                    new StringField('operationpc_cmd_fk', true),
                    new IntegerField('ordre', true)
                )
            );
            $this->dataset->AddLookupField('operationpc_cmd_fk', 'operationpc', new StringField('ops_name'), new StringField('description', false, false, false, false, 'operationpc_cmd_fk_description', 'operationpc_cmd_fk_description_operationpc'), 'operationpc_cmd_fk_description_operationpc');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id_cmdauto', 'id_cmdauto', 'Id Cmdauto'),
                new FilterColumn($this->dataset, 'cmd_auto', 'cmd_auto', 'Cmd Auto'),
                new FilterColumn($this->dataset, 'operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk'),
                new FilterColumn($this->dataset, 'ordre', 'ordre', 'Ordre')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['cmd_auto'])
                ->addColumn($columns['operationpc_cmd_fk'])
                ->addColumn($columns['ordre']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('operationpc_cmd_fk');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('cmd_auto');
            
            $filterBuilder->addColumn(
                $columns['cmd_auto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('operationpc_cmd_fk_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_operationpc_cmd_fk_description_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('operationpc_cmd_fk', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_operationpc_cmd_fk_description_search');
            
            $text_editor = new TextEdit('operationpc_cmd_fk');
            
            $filterBuilder->addColumn(
                $columns['operationpc_cmd_fk'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('ordre_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('1', '1');
            $main_editor->addChoice('2', '2');
            $main_editor->addChoice('3', '3');
            $main_editor->addChoice('4', '4');
            $main_editor->addChoice('5', '5');
            $main_editor->addChoice('6', '6');
            $main_editor->addChoice('7', '7');
            $main_editor->addChoice('8', '8');
            $main_editor->addChoice('9', '9');
            $main_editor->addChoice('10', '10');
            $main_editor->addChoice('11', '11');
            $main_editor->addChoice('12', '12');
            $main_editor->addChoice('13', '13');
            $main_editor->addChoice('14', '14');
            $main_editor->addChoice('15', '15');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('ordre');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $filterBuilder->addColumn(
                $columns['ordre'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_cmd_auto_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_operationpc_cmd_fk_description_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ordre field
            //
            $column = new NumberViewColumn('ordre', 'ordre', 'Ordre', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_cmd_auto_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_operationpc_cmd_fk_description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ordre field
            //
            $column = new NumberViewColumn('ordre', 'ordre', 'Ordre', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for cmd_auto field
            //
            $editor = new TextAreaEdit('cmd_auto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Cmd Auto', 'cmd_auto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for operationpc_cmd_fk field
            //
            $editor = new DynamicCombobox('operationpc_cmd_fk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Operationpc Cmd Fk', 'operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'edit_operationpc_cmd_fk_description_search', $editor, $this->dataset, $lookupDataset, 'ops_name', 'description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ordre field
            //
            $editor = new ComboBox('ordre_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('1', '1');
            $editor->addChoice('2', '2');
            $editor->addChoice('3', '3');
            $editor->addChoice('4', '4');
            $editor->addChoice('5', '5');
            $editor->addChoice('6', '6');
            $editor->addChoice('7', '7');
            $editor->addChoice('8', '8');
            $editor->addChoice('9', '9');
            $editor->addChoice('10', '10');
            $editor->addChoice('11', '11');
            $editor->addChoice('12', '12');
            $editor->addChoice('13', '13');
            $editor->addChoice('14', '14');
            $editor->addChoice('15', '15');
            $editColumn = new CustomEditColumn('Ordre', 'ordre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for cmd_auto field
            //
            $editor = new TextAreaEdit('cmd_auto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Cmd Auto', 'cmd_auto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for operationpc_cmd_fk field
            //
            $editor = new DynamicCombobox('operationpc_cmd_fk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Operationpc Cmd Fk', 'operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'multi_edit_operationpc_cmd_fk_description_search', $editor, $this->dataset, $lookupDataset, 'ops_name', 'description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ordre field
            //
            $editor = new ComboBox('ordre_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('1', '1');
            $editor->addChoice('2', '2');
            $editor->addChoice('3', '3');
            $editor->addChoice('4', '4');
            $editor->addChoice('5', '5');
            $editor->addChoice('6', '6');
            $editor->addChoice('7', '7');
            $editor->addChoice('8', '8');
            $editor->addChoice('9', '9');
            $editor->addChoice('10', '10');
            $editor->addChoice('11', '11');
            $editor->addChoice('12', '12');
            $editor->addChoice('13', '13');
            $editor->addChoice('14', '14');
            $editor->addChoice('15', '15');
            $editColumn = new CustomEditColumn('Ordre', 'ordre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for cmd_auto field
            //
            $editor = new TextAreaEdit('cmd_auto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Cmd Auto', 'cmd_auto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for operationpc_cmd_fk field
            //
            $editor = new DynamicCombobox('operationpc_cmd_fk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Operationpc Cmd Fk', 'operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'insert_operationpc_cmd_fk_description_search', $editor, $this->dataset, $lookupDataset, 'ops_name', 'description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ordre field
            //
            $editor = new ComboBox('ordre_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('1', '1');
            $editor->addChoice('2', '2');
            $editor->addChoice('3', '3');
            $editor->addChoice('4', '4');
            $editor->addChoice('5', '5');
            $editor->addChoice('6', '6');
            $editor->addChoice('7', '7');
            $editor->addChoice('8', '8');
            $editor->addChoice('9', '9');
            $editor->addChoice('10', '10');
            $editor->addChoice('11', '11');
            $editor->addChoice('12', '12');
            $editor->addChoice('13', '13');
            $editor->addChoice('14', '14');
            $editor->addChoice('15', '15');
            $editColumn = new CustomEditColumn('Ordre', 'ordre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_cmd_auto_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_operationpc_cmd_fk_description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for ordre field
            //
            $column = new NumberViewColumn('ordre', 'ordre', 'Ordre', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_cmdauto field
            //
            $column = new NumberViewColumn('id_cmdauto', 'id_cmdauto', 'Id Cmdauto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_cmd_auto_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_operationpc_cmd_fk_description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for ordre field
            //
            $column = new NumberViewColumn('ordre', 'ordre', 'Ordre', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_cmd_auto_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('cmd_autoGrid_operationpc_cmd_fk_description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for ordre field
            //
            $column = new NumberViewColumn('ordre', 'ordre', 'Ordre', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_cmd_auto_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_operationpc_cmd_fk_description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_cmd_auto_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_operationpc_cmd_fk_description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_cmd_auto_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_operationpc_cmd_fk_description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_operationpc_cmd_fk_description_search', 'ops_name', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_operationpc_cmd_fk_description_search', 'ops_name', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for cmd_auto field
            //
            $column = new TextViewColumn('cmd_auto', 'cmd_auto', 'Cmd Auto', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_cmd_auto_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('operationpc_cmd_fk', 'operationpc_cmd_fk_description', 'Operationpc Cmd Fk', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'cmd_autoGrid_operationpc_cmd_fk_description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_operationpc_cmd_fk_description_search', 'ops_name', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`operationpc`');
            $lookupDataset->addFields(
                array(
                    new StringField('ops_name', true, true),
                    new StringField('description', true),
                    new IntegerField('etat_ops', true)
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_operationpc_cmd_fk_description_search', 'ops_name', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new cmd_autoPage("cmd_auto", "cmd_auto.php", GetCurrentUserPermissionSetForDataSource("cmd_auto"), 'UTF-8');
        $Page->SetTitle('Automation');
        $Page->SetMenuLabel('Automation');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("cmd_auto"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
