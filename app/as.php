<?php

namespace App\Http\Controllers\Framework\DataProcessor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Framework\CodingProcessor\CodingProcessor;
use App\Model\Projects\Project;
use App\Model\Projects\Studies\Study;
use App\Model\Projects\Studies\StudyStructure;
use App\Model\Projects\Universes\Universe;
use App\Model\Projects\Universes\UniverseStructure;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;

class DataProcessor extends Controller
{
    private $tableConnection = null;
    private $tableName = null;
    private $study = null;
    private $processedRangeInitial = null;
    private $processedRangeFinal = null;
    private $processedRows = null;
    private $processedDinamicRows = [];
    private $processedColumns = null;
    private $processedFilterFields = null;
    private $processedFilterFieldsValues = null;
    private $processedCalculationGroup = null;
    private $processedCalculationGroupMode = null;
    private $processedFrequencyTotal = false;
    private $processedVerticalPercent = false;
    private $processedHorizontalPercent = false;
    private $processedTotalPercent = false;
    private $processedVerticalStatistical = false;
    private $processedHorizontalStatistical = false;
    private $processedPercentCases = true;
    private $processedWithUniverse = true;
    private $activeReturnGeneralData = false;
    private $generalDataStudy;
    private $dataGeneralProcess;
    public $disabledNullValues = true;

    public $data = null;

    public function __construct($study)
    {
        $this->study = $study;
        $this->setTableConnection('CAMTECH_Dashboard_Projects');
        $this->setTableName('CT_PRJ_StudyTable_ID_');
    }

    /**
     * @return bool
     */
    public function isActiveReturnGeneralData(): bool
    {
        return $this->activeReturnGeneralData;
    }

    /**
     * @param bool $activeReturnGeneralData
     */
    public function setActiveReturnGeneralData(bool $activeReturnGeneralData)
    {
        $this->activeReturnGeneralData = $activeReturnGeneralData;
    }


    /**
     * Set the data table to get the data.
     *
     * @param $tableConnection
     * @return void
     */
    public function setTableConnection($tableConnection)
    {
        $this->tableConnection = $tableConnection;
    }

    /**
     * Set the data table to get the data.
     *
     * @param $tableName
     * @return void
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName . $this->study;
    }

    /**
     * Set the range of the data to be processed.
     *
     * @param $processingRange
     * @return void
     */
    public function setProcessedRange($processingRange)
    {
        $this->processedRangeInitial = $processingRange[0];
        $this->processedRangeFinal = $processingRange[1];
    }

    /**
     * Set the rows of the data to be processed.
     *
     * @param $processingRows
     * @return void
     */
    public function setProcessedRows($processingRows)
    {
        $this->processedRows = $processingRows;
    }

    /**
     * Set the dinamic rows of the data to be processed.
     *
     * @param $processingDynamicRows
     * @return void
     */
    public function setProcessedDynamicRows($processingDynamicRows)
    {
        $this->processedDinamicRows = $processingDynamicRows;
    }

    /**
     * Set the columns of the data to be processed.
     *
     * @param $processingColumns
     * @return void
     */
    public function setProcessedColumns($processingColumns)
    {
        $this->processedColumns = $processingColumns;
    }

    /**
     * Set the filter fields of the data to be processed.
     *
     * @param $processingFilterFields
     * @param $processingFilterFieldsValues
     * @return void
     */
    public function setProcessedFilterData($processingFilterFields, $processingFilterFieldsValues)
    {
        $this->processedFilterFields = $processingFilterFields;
        $this->processedFilterFieldsValues = $processingFilterFieldsValues;
    }

    /**
     * Set the calculation group of the data to be processed.
     *
     * @param $processedCalculationGroup
     * @return void
     */
    public function setProcessedCalculationGroup($processedCalculationGroup)
    {
        $this->processedCalculationGroup = $processedCalculationGroup;
    }

    /**
     * Set the calculation group mode of the data to be processed.
     *
     * @param $processedCalculationGroupMode
     * @return void
     */
    public function setProcessedCalculationModeGroup($processedCalculationGroupMode)
    {
        $this->processedCalculationGroupMode = $processedCalculationGroupMode;
    }

    /**
     * Active frequency value processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedFrequencyTotal()
    {
        $this->processedFrequencyTotal = true;
    }

    /**
     * Inactive frequency value processed for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedFrequencyTotal()
    {
        $this->processedFrequencyTotal = false;
    }

    /**
     * Active vertical percent processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedVerticalPercent()
    {
        $this->processedVerticalPercent = true;
    }

    /**
     * Inactive vertical percent processed for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedVerticalPercent()
    {
        $this->processedVerticalPercent = false;
    }

    /**
     * Active horizontal percent processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedHorizontalPercent()
    {
        $this->processedHorizontalPercent = true;
    }

    /**
     * Inactive horizontal percent processed for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedHorizontalPercent()
    {
        $this->processedHorizontalPercent = false;
    }

    /**
     * Active total percent processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedTotalPercent()
    {
        $this->processedTotalPercent = true;
    }

    /**
     * Inactive total percent processed for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedTotalPercent()
    {
        $this->processedTotalPercent = false;
    }

    /**
     * Active vertical statistical processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedVerticalStatistical()
    {
        $this->processedVerticalStatistical = true;
    }

    /**
     * Inactive vertical statistical processed for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedVerticalStatistical()
    {
        $this->processedVerticalStatistical = false;
    }

    /**
     * Active horizontal statistical processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedHorizontalStatistical()
    {
        $this->processedHorizontalStatistical = true;
    }

    /**
     * Inactive horizontal statistical processed for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedHorizontalStatistical()
    {
        $this->processedHorizontalStatistical = false;
    }

    /**
     * Active percent in cases processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedPercentInCase()
    {
        $this->processedPercentCases = true;
    }

    /**
     * Active percent in answers processed for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedPercentInAnswers()
    {
        $this->processedPercentCases = false;
    }

    /**
     * Set the universe for the data to be processed.
     *
     * @return void
     */
    public function ActiveProcessedWithUniverse()
    {
        $this->processedWithUniverse = true;
    }

    /**
     * Disabled the universe for the data to be processed.
     *
     * @return void
     */
    public function InactiveProcessedWithUniverse()
    {
        $this->processedWithUniverse = false;
    }

    /**
     * clear the filter was sent by the user.
     *
     * @return void.
     */
    //
    private function ClearFilters()
    {
        if ($this->processedFilterFields !== null) {
            foreach ($this->processedFilterFields as $key => $filter) {

                $filterValues = $this->processedFilterFieldsValues[$filter];
                if ($filterValues == null) {
                    unset($this->processedFilterFields[$key]);
                    sort($this->processedFilterFields);
                    unset($this->processedFilterFieldsValues[$filter]);
                }

            }
        }

    }
    /**
     * Get the standard data processed by this class.
     * with the data processed.
     * @return array
     */
    //
    public function getStandardProcessedData()
    {
        $this->ClearFilters();
        $processedData = array();
        $fieldsComparative = $this->getFieldsComparative();
        $data = $this->getDataProcessed($fieldsComparative);

        if ($this->processedCalculationGroup === null) {
            $processedData = $this->getProcessedData($data, $fieldsComparative);

        } else {
            $groupFieldsStructure = StudyStructure::where('study', $this->study)
                ->whereIn('id', $this->processedCalculationGroup)
                ->get();
            $groupFields = array();
            foreach ($groupFieldsStructure as $field) {
                $groupFields[$field->field_name] = CodingProcessor::getCodeDescriptionList($field->coding);
            }
            $groupsAvailables = $this->getGroupsAvailables($data, $groupFields, $this->processedCalculationGroupMode);

            foreach ($groupsAvailables as $key => $group) {
                $groupData = $this->getGroupData($data, $group);
                $groupDescription = array();

                foreach ($group as $fieldName => $fieldValue) {
                    if (isset($groupFields[$fieldName][$fieldValue])) {
                        $groupDescription[] = $fieldName . ' => ' . $groupFields[$fieldName][$fieldValue];
                    } else {
                        $fieldValueTemp = explode(';', $fieldValue);
                        $description = "";

                        foreach ($fieldValueTemp as $fieldKey) {
                            if (isset($groupFields[$fieldName][(int)($fieldKey)])) {
                                $description = $description . " " . $groupFields[$fieldName][(int)($fieldKey)];
                            }

                        }
                        $groupDescription[] = $description;
                    }
                }

                $processedData[$key]['@group'] = implode(', ', $groupDescription);
                $processedData[$key]['@data'] = $this->getProcessedData($groupData, $fieldsComparative);
                $processedData[$key]['@quantity'] = count($groupData);
            }
        }


        return $processedData;
    }

    /**
     * Get the with the groups availables.
     *
     * @param $data
     * @param $groupFields
     * @param $processedCalculationGroupMode
     * @return array
     */
    public function getGroupsAvailables($data, $groupFields, $processedCalculationGroupMode)
    {
        $groupsAvailables = array();
        $groupsAvailableData = array();
        foreach ($groupFields as $fieldName => $fieldValues) {
            foreach ($data as $row) {
                if (!isset($groupsAvailableData[$fieldName])) {
                    $groupsAvailableData[$fieldName][] = $row->{$fieldName};
                } else {
                    if (!in_array($row->{$fieldName}, $groupsAvailableData[$fieldName])) {
                        $groupsAvailableData[$fieldName][] = $row->{$fieldName};
                        sort($groupsAvailableData[$fieldName]);
                    }
                }
            }
        }
        if ($processedCalculationGroupMode == 'off') {
            foreach ($groupsAvailableData as $fieldName => $fieldValues) {
                foreach ($fieldValues as $value) {
                    $groupsAvailables[] = $groupFilter = [
                        $fieldName => $value
                    ];
                }
            }
        } else {
            $index = 0;
            $quantity = count($groupsAvailableData);
            $groupsAvailables = $this->getCombinatedCases($groupsAvailableData, $index, $quantity);
        }
        return $groupsAvailables;
    }

    /**
     * Get the multiple combination.
     *
     * @param $groupsAvailableData
     * @param $index
     * @param $quantity
     * @return array .
     */
    public function getCombinatedCases($groupsAvailableData, $index, $quantity)
    {
        $groupsAvailables = array();
        $fields = array_keys($groupsAvailableData);

        if ($index >= 0) {
            $values = $groupsAvailableData[$fields[$index]];
            foreach ($values as $value) {
                $groupsAvailables[] =
                    [
                        $fields[$index] => $value
                    ];
            }
            if ($index + 1 < $quantity) {
                $nextData = $this->getCombinatedCases($groupsAvailableData, $index + 1, $quantity);
                $nextGroupsAvailables = array();
                foreach ($groupsAvailables as $key => $groups) {
                    foreach ($nextData as $keyNext => $groupsNext) {
                        $nextGroupsAvailables[] = array_merge(
                            $groupsAvailables[$key],
                            $groupsNext
                        );
                    }
                }
                $groupsAvailables = $nextGroupsAvailables;
            }
        }

        return $groupsAvailables;
    }

    /**
     * Get the with the groups data availables.
     *
     * @param $data
     * @param $group
     * @return array .
     */
    public function getGroupData($data, $group)
    {
        $groupData = array();
        foreach ($data as $row) {
            $validRow = true;
            foreach ($group as $fieldName => $fieldValue) {
                if ($row->{$fieldName} != $fieldValue) {
                    $validRow = false;
                }
            }
            if ($validRow) {
                $groupData[] = $row;
            }
        }
        return $groupData;
    }

    /**
     * Get the processed data according to the data received.
     *
     * @param $data
     * @param $fieldsComparative
     * @return array with the data processed.
     */
    public function getProcessedData($data, $fieldsComparative)
    {
        $processedData = array();

        if (count($data) > 0) {
            foreach ($this->processedRows as $variableRow) {
                if (substr($variableRow, 0, 1) == "@") {
                    $studyRow = new Object_();
                    $studyRow->{"study"} = $this->study;
                    $studyRow->{"field_name"} = $variableRow;
                    $studyRow->{"field_description"} = $variableRow;
                    $studyRow->{"field_type"} = 'N';
                    $studyRow->{"field_required"} = 'S';
                    $studyRow->{"field_display"} = 'S';
                    $studyRow->{"coding"} = null;
                    $studyRow->{"field_kind"} = 'VRT';

                } else {
                    $studyRow = StudyStructure::where('id', $variableRow)->first();
                }
                $study = Study::find($this->study);
                if ($studyRow->study == $this->study) {
                    $project = Project::find($study->project);
                    $universe = Universe::find($study->universe);
                    $processedData['@project'] = $project->name;
                    $processedData['@id'] = $study->id;
                    $processedData['@code'] = $study->internal_code;
                    $processedData['@study'] = $study->name;
                    $processedData['@universe'] = (!isset($universe->name)) ? '' : $universe->name;

                    $periodField = StudyStructure::where('study', $this->study)
                        ->where('field_kind', 'MDC')
                        ->first();
                    if ($this->processedRangeInitial != $this->processedRangeFinal) {
                        $processedData['@filterDescripcion'] =
                            CodingProcessor::getDescriptionFromCode($this->processedRangeInitial, $periodField->coding) . ' HASTA ' .
                            CodingProcessor::getDescriptionFromCode($this->processedRangeFinal, $periodField->coding) . '';
                    } else {
                        $processedData['@filterDescripcion'] =
                            CodingProcessor::getDescriptionFromCode($this->processedRangeInitial, $periodField->coding);
                    }

                    if (!empty($this->processedFilterFields)) {
                        $processedDataFilter = array();
                        $filterRow = StudyStructure::whereIn('id', $this->processedFilterFields)->get();
                        foreach ($filterRow as $filter) {
                            $processedDataFilterValues = array();
                            if (isset($this->processedFilterFieldsValues[$filter->id])) {
                                $filterValues = $this->processedFilterFieldsValues[$filter->id];
                                if (!empty($filter->id)) {
                                    foreach ($filterValues as $values) {
                                        $processedDataFilterValues[] = CodingProcessor::getDescriptionFromId($values, $filter->coding);
                                    }
                                }

                                $processedDataFilter[] = $filter->field_description . ' => {' . implode(', ', $processedDataFilterValues) . '}';
                            }

                        }

                        if (count($processedDataFilter) > 0) {
                            $processedData['@filterDescripcion'] .= '<br>' .
                                implode(', ', $processedDataFilter);
                        }
                    }


                    $processedData['@data'][$variableRow]['@field_name'] = $studyRow->field_name;
                    $processedData['@data'][$variableRow]['@field_description'] = $studyRow->field_description;
                    $processedData['@data'][$variableRow]['@field_type'] = $studyRow->field_type;
                    $processedData['@data'][$variableRow]['@field_required'] = $studyRow->field_required;
                    $processedData['@data'][$variableRow]['@field_display'] = $studyRow->field_display;
                    $processedData['@data'][$variableRow]['@field_kind'] = $studyRow->field_kind;


                    if ($this->processedWithUniverse) {
                        if (!isset($studyRow->universe)) {
                            $processedData['@data'][$variableRow]['@field_universe'] = 'N/A';
                        } else {
                            $universeStructure = UniverseStructure::find($studyRow->universe);
                            $processedData['@data'][$variableRow]['@field_universe'] = $universeStructure->field_name . ' - ' . $universeStructure->field_description;
                        }
                    }


                    $processedData['@data'][$variableRow]['@data'] = $this->getProcessedRow($data, $studyRow);
                    if ($this->processedColumns !== null) {
                        foreach ($this->processedColumns as $idVariableColumn) {
                            $studyColumn = StudyStructure::where('id', $idVariableColumn)->first();
                            $processedData['@data'][$variableRow]['@columns'][$idVariableColumn] = $this->getProcessedColumn($data, $studyRow, $studyColumn, $fieldsComparative, $processedData['@data'][$variableRow]['@data']);
                        }
                    }

                    $processedData['@data'][$variableRow]['@field_coding'] = CodingProcessor::getCodeDescriptionList($studyRow->coding);
                    $processedData['@data'][$variableRow]['@field_coding'][0] = 'N/A';
                    asort($processedData['@data'][$variableRow]['@data']['@dataFrequency']);
                    $codesRequired = array_keys($processedData['@data'][$variableRow]['@data']['@dataFrequency']);

                    foreach ($codesRequired as $code) {
                        if (!isset($processedData['@data'][$variableRow]['@field_coding'][$code])) {
                            if ($studyRow->coding !== null) {
                                if (trim($code) != '' and $code !== null) {
                                    $processedData['@data'][$variableRow]['@field_coding'][$code] = 'ERROR_CODE[' . $code . ']';
                                } else {
                                    $processedData['@data'][$variableRow]['@field_coding'][$code] = 'Indefinido';
                                }
                            } else {
                                if (trim($code) == '' or $code === null) {
                                    $processedData['@data'][$variableRow]['@field_coding'][$code] = 'Indefinido';
                                } else {
                                    $processedData['@data'][$variableRow]['@field_coding'][$code] = $code;
                                }
                            }
                        }
                    }

                    if ($this->activeReturnGeneralData) {
                        $processedData['@dataGeneralProcess'] = $this->dataGeneralProcess;
                    }

                }
            }
        }

        return $processedData;
    }

    /**
     * Get the data processed of the row.
     *
     * @param $data
     * @param $studyRow
     * @return array .
     */
    public function getProcessedRow($data, $studyRow)
    {
        $this->dataGeneralProcess = $data;
        $processedRow = array();
        foreach ($data as $row) {
            $values = explode(';', $row->{$studyRow->field_name});
            $weighted = 0;
            foreach ($values as $value) {

                if (!empty($value) or !empty($this->processedDinamicRows) or $this->disabledNullValues == true) {
                    if ($this->processedWithUniverse) {
                        $weighted = $row->{'@EXPANSION_FACTOR_MOBILE_PERIOD'};
                    } else {
                        $weighted = 1;
                    }
                    if (isset($processedRow['@dataFrequency'][$value])) {
                        $processedRow['@dataFrequency'][$value] += $weighted;
                    } else {
                        $processedRow['@dataFrequency'][$value] = $weighted;
                    }
                    if (isset($processedRow['@dataAnswers'])) {
                        $processedRow['@dataAnswers'] += $weighted;
                    } else {
                        $processedRow['@dataAnswers'] = $weighted;
                    }
                }

            }
            if (isset($processedRow['@dataCases'])) {
                $processedRow['@dataCases'] += $weighted;
                $processedRow['@dataCasesReal'] += 1;
            } else {
                $processedRow['@dataCases'] = $weighted;
                $processedRow['@dataCasesReal'] = 1;
            }
            if ($studyRow->field_type == "N") {
                $statisticalVerticalData[] = $row->{$studyRow->field_name};
                $statisticalVerticalDataWeighted[] = $weighted;
            }
        }

        if (isset($processedRow['@dataFrequency'])) {
            asort($processedRow['@dataFrequency']);
        }

        $processedRow['@dataFrequencyVerticalPercentBase%'] = 100;
        if ($this->processedPercentCases) {
            $processedRow['@dataFrequencyVerticalPercentBase'] = $processedRow['@dataCases'];
        } else {
            $processedRow['@dataFrequencyVerticalPercentBase'] = $processedRow['@dataAnswers'];
        }


        if (isset($processedRow['@dataFrequency'])) {
            foreach ($processedRow['@dataFrequency'] as $key => $value) {
                $processedRow['@dataFrequencyVerticalPercent'][$key] = ($value / $processedRow['@dataFrequencyVerticalPercentBase']) * 100;
            }
        }

        if ($this->processedVerticalStatistical) {
            if ($studyRow->field_type == "N") {
                $processedRow['@dataStatistics'] = $this->getDataStatistics($statisticalVerticalData, $statisticalVerticalDataWeighted, $processedRow['@dataCases']);
            }
        }

        if (isset($processedRow['@dataFrequencyVerticalPercent'])) {
            asort($processedRow['@dataFrequencyVerticalPercent']);
        }

        return $processedRow;
    }

    /**
     * Get the data processed of the column.
     *
     * @param $data
     * @param $variableRow
     * @param $variableColumn
     * @param $fieldsComparative
     * @param $processedDataRow
     * @return array with the data processed.
     */
    public function getProcessedColumn($data, $variableRow, $variableColumn, $fieldsComparative, $processedDataRow)
    {
        $processedColumn = array();
        $processedColumn['@field_name'] = $variableColumn->field_name;
        $processedColumn['@field_description'] = $variableColumn->field_description;
        $processedColumn['@field_type'] = $variableColumn->field_type;
        $processedColumn['@field_coding'] = CodingProcessor::getCodeDescriptionList($variableColumn->coding);
        $processedColumn['@field_coding'][0] = 'N/A';

        foreach ($data as $row) {
            $rowValues = explode(';', $row->{$variableRow->field_name});
            $columnValues = explode(';', $row->{$variableColumn->field_name});

            $rowValues = array_filter($rowValues);
            $columnValues = array_filter($columnValues);

            if ((!empty($columnValues) and !empty($rowValues)) or !empty($this->processedDinamicRows) or $this->disabledNullValues == true) {
                if ($this->processedWithUniverse) {
                    if (!in_array($variableColumn->field_name, $fieldsComparative)) {
                        $weighted = $row->{'@EXPANSION_FACTOR_MOBILE_PERIOD'};
                    } else {
                        $weighted = $row->{'@EXPANSION_FACTOR_' . $variableColumn->field_name};
                    }
                } else {
                    $weighted = 1;
                }

                foreach ($columnValues as $columnValue) {
                    if (isset($processedColumn['@data'][$columnValue]['@dataCases'])) {
                        $processedColumn['@data'][$columnValue]['@dataCases'] += $weighted;
                        $processedColumn['@data'][$columnValue]['@dataCasesReal'] += 1;
                    } else {
                        $processedColumn['@data'][$columnValue]['@dataCases'] = $weighted;
                        $processedColumn['@data'][$columnValue]['@dataCasesReal'] = 1;
                    }
                    foreach ($rowValues as $rowValue) {

                        if (isset($processedColumn['@data'][$columnValue]['@dataFrequency'][$rowValue])) {
                            $processedColumn['@data'][$columnValue]['@dataFrequency'][$rowValue] += $weighted;
                        } else {
                            $processedColumn['@data'][$columnValue]['@dataFrequency'][$rowValue] = $weighted;
                        }
                        if (isset($processedColumn['@data'][$columnValue]['@dataAnswers'])) {
                            $processedColumn['@data'][$columnValue]['@dataAnswers'] += $weighted;
                        } else {
                            $processedColumn['@data'][$columnValue]['@dataAnswers'] = $weighted;
                        }
                        if ($this->processedPercentCases) {
                            $processedColumn['@data'][$columnValue]['@dataBaseData'] = $processedColumn['@data'][$columnValue]['@dataCases'];
                        } else {
                            $processedColumn['@data'][$columnValue]['@dataBaseData'] = $processedColumn['@data'][$columnValue]['@dataAnswers'];
                        }
                        if ($variableColumn->field_type == "N") {
                            $statisticalHorizontalData[$rowValue][] = $columnValue;
                            $statisticalHorizontalDataWeighted[$rowValue][] = $weighted;
                            $statisticalHorizontalDataMain[] = $columnValue;
                            $statisticalHorizontalDataMainWeighted[] = $weighted;
                        }
                    }
                    if ($this->processedPercentCases) {
                        $processedColumn['@data'][$columnValue]['@dataBaseData'] = $processedColumn['@data'][$columnValue]['@dataCases'];
                    } else {
                        $processedColumn['@data'][$columnValue]['@dataBaseData'] = $processedColumn['@data'][$columnValue]['@dataAnswers'];
                    }
                    if ($variableRow->field_type == "N") {
                        $statisticalVerticalData[$columnValue][] = $row->{$variableRow->field_name};
                        $statisticalVerticalDataWeighted[$columnValue][] = $weighted;
                    }
                }

            }
        }

        $codesRequired = array_keys($processedColumn['@data']);
        foreach ($codesRequired as $code) {
            if (!isset($processedColumn['@field_coding'][$code])) {
                $processedColumn['@field_coding'][$code] = 'ERROR_CODE[' . $code . ']';
            }
        }
        foreach ($processedColumn['@data'] as $columnValue => $data) {

// Temporal se debe buscar la causa del error.
            if (isset($processedColumn['@data'][$columnValue]['@dataFrequency'])) {

                foreach ($processedColumn['@data'][$columnValue]['@dataFrequency'] as $key => $value) {
                    if ($this->processedVerticalPercent) {
                        if ($this->processedPercentCases) {
                            $dataBaseUsed = $processedColumn['@data'][$columnValue]['@dataCases'];
                        } else {
                            $dataBaseUsed = $processedColumn['@data'][$columnValue]['@dataAnswers'];
                        }
                        $processedColumn['@data'][$columnValue]['@dataFrequencyVerticalPercentBase%'] = 100;
                        $processedColumn['@data'][$columnValue]['@dataFrequencyVerticalPercentBase'] = $dataBaseUsed;
                        $processedColumn['@data'][$columnValue]['@dataFrequencyVerticalPercent'][$key] = ($value / $dataBaseUsed) * 100;
                    }
                    if ($this->processedHorizontalPercent) {
                        if ($this->processedPercentCases) {
                            $dataBaseUsed = $processedColumn['@data'][$columnValue]['@dataCases'];
                        } else {
                            $dataBaseUsed = $processedColumn['@data'][$columnValue]['@dataAnswers'];
                        }
                        $processedColumn['@data'][$columnValue]['@dataFrequencyHorizontalPercentBase%'] = ($dataBaseUsed / $processedDataRow['@dataCases']) * 100;
                        $processedColumn['@data'][$columnValue]['@dataFrequencyHorizontalPercentBase'] = $dataBaseUsed;
                        $processedColumn['@data'][$columnValue]['@dataFrequencyHorizontalPercent'][$key] = ($value / $processedDataRow['@dataFrequency'][$key]) * 100;
                    }
                    if ($this->processedTotalPercent) {
                        if ($this->processedPercentCases) {
                            $dataBaseUsed = $processedDataRow['@dataCases'];
                        } else {
                            $dataBaseUsed = $processedDataRow['@dataAnswers'];
                        }
                        $processedColumn['@data'][$columnValue]['@dataFrequencyTotalPercentBase%'] = ($dataBaseUsed / $processedDataRow['@dataCases']) * 100;
                        $processedColumn['@data'][$columnValue]['@dataFrequencyTotalPercentBase'] = $dataBaseUsed;
                        $processedColumn['@data'][$columnValue]['@dataFrequencyTotalPercent'][$key] = ($value / $dataBaseUsed) * 100;
                    }
                }

            }


        }

        if ($this->processedVerticalStatistical) {
            if ($variableRow->field_type == "N") {
                foreach ($processedColumn['@data'] as $columnValue => $data) {
                    $processedColumn['@data'][$columnValue]['@dataStatistics'] =
                        $this->getDataStatistics(
                            $statisticalVerticalData[$columnValue],
                            $statisticalVerticalDataWeighted[$columnValue],
                            $processedColumn['@data'][$columnValue]['@dataCases']
                        );
                }
            }
        }
        if ($this->processedHorizontalStatistical) {
            if ($variableColumn->field_type == "N") {
                $processedColumn['@dataStatisticsTypes'] = null;
                foreach ($statisticalHorizontalData as $key => $value) {
                    $processedColumn['@dataStatistics'][$key] =
                        $this->getDataStatistics(
                            $statisticalHorizontalData[$key],
                            $statisticalHorizontalDataWeighted[$key],
                            $processedDataRow['@dataFrequency'][$key]
                        );
                    if ($processedColumn['@dataStatisticsTypes'] === null) {
                        $processedColumn['@dataStatisticsTypes'] = array_keys($processedColumn['@dataStatistics'][$key]);
                    }
                }
                $processedColumn['@dataStatisticsMain'] = $this->getDataStatistics(
                    $statisticalHorizontalDataMain,
                    $statisticalHorizontalDataMainWeighted,
                    $processedDataRow['@dataCases']
                );;
            }
        }
        ksort($processedColumn['@data']);
        return $processedColumn;
    }

    /**
     * Get the data statistics from the values received.
     *
     * @param $statisticalData
     * @param $statisticalDataWeighted
     * @param $dataCases
     * @return array with the data statistical.
     */
    public function getDataStatistics($statisticalData, $statisticalDataWeighted, $dataCases)
    {
        $statistics = array();
        $statistics['@Cases'] = $dataCases;
        $statistics['@Min'] = min($statisticalData);
        $statistics['@Max'] = max($statisticalData);
        if (!$this->processedWithUniverse) {
            $statistics['@Sum'] = array_sum($statisticalData);
            $statistics['@Media'] = array_sum($statisticalData) / $dataCases;

            rsort($statisticalData);
            $middle = round(count($statisticalData) / 2);
            $statistics['@Median'] = $statisticalData[$middle - 1];

            $v = array_count_values($statisticalData);
            arsort($v);
            foreach ($v as $k => $v) {
                $total = $k;
                break;
            }
            $statistics['@Mode'] = $total;

            $statistics['@Deviation'] = $this->getStandardDeviationData(
                $statistics['@Cases'],
                $statistics['@Media'],
                $statisticalData,
                null
            );

        } else {
            $statistics['@Sum'] = 0;
            $statistics['@Media'] = 0;
            $frequencyTable = array();
            foreach ($statisticalData as $key => $value) {
                $statistics['@Sum'] += $value * $statisticalDataWeighted [$key];
                if (!isset($frequencyTable [$value])) {
                    $frequencyTable [$value] = (int)$statisticalDataWeighted [$key];
                } else {
                    $frequencyTable [$value] += (int)$statisticalDataWeighted [$key];
                }
            }
            $statistics['@Media'] = $statistics['@Sum'] / $dataCases;
            ksort($frequencyTable);
            $previousValue = 0;
            foreach ($frequencyTable as $key => $value) {
                $frequencyTableAccumulated[$key] = $value + $previousValue;
                $previousValue = $frequencyTableAccumulated[$key];
            }
            $middle = ($dataCases / 2);
            foreach ($frequencyTableAccumulated as $key => $value) {
                if ($middle - 1 <= $value) {
                    $statistics['@Median'] = $key;
                    break;
                }
            }
            $total = 0;
            arsort($frequencyTable);
            foreach ($frequencyTable as $k => $v) {
                $total = $k;
                break;
            }
            $statistics['@Mode'] = $total;
            $statistics['@Deviation'] = $this->getStandardDeviationData(
                $statistics['@Cases'],
                $statistics['@Media'],
                $statisticalData,
                $statisticalDataWeighted
            );
        }
        $statistics['@Variance'] = pow($statistics['@Deviation'], 2);
        return $statistics;
    }

    /**
     * Get the standard deviation from the database.
     *
     * @param $cases
     * @param $media
     * @param $statisticalVerticalData
     * @param $statisticalVerticalDataWeighted
     * @return array.
     */
    public function getStandardDeviationData($cases, $media, $statisticalVerticalData, $statisticalVerticalDataWeighted)
    {
        $mediaDifference = 0;
        foreach ($statisticalVerticalData as $key => $value) {
            if ($statisticalVerticalDataWeighted !== null) {
                $mediaDifference += pow($value - $media, 2) * round($statisticalVerticalDataWeighted[$key]);
            } else {
                $mediaDifference += pow($value - $media, 2);
            }
        }
        if ($cases > 1) {
            $variance = $mediaDifference / ($cases - 1);
        } else {
            $variance = $mediaDifference;
        }
        $deviation = sqrt($variance);

        return $deviation;
    }

    /**
     * Get the data from the database processed with the selections and filters.
     *
     * @param $fieldsComparative
     * @return array.
     */
    public function getDataProcessed($fieldsComparative)
    {
        $data = array();
        if (
            $this->processedRangeInitial !== null and
            $this->processedRangeFinal !== null and
            (
                $this->processedRows !== null or
                $this->processedDinamicRows !== null
            )
        ) {
            if ($this->processedRows !== null) {
                $fieldsSelected = $this->processedRows;
            } else {
                $fieldsSelected = array();
            }
            if ($this->processedColumns !== null) {
                $fieldsSelected = array_merge($fieldsSelected, $this->processedColumns);
            }
            if ($this->processedFilterFields !== null) {
                $fieldsSelected = array_merge($fieldsSelected, $this->processedFilterFields);
            }
            if ($this->processedCalculationGroup !== null) {
                $fieldsSelected = array_merge($fieldsSelected, $this->processedCalculationGroup);
            }
            $fieldsSelectedQuery = array();
            $fieldsQuery = StudyStructure::where('study', $this->study)
                ->whereIn('id', $fieldsSelected)
                ->get();
            foreach ($fieldsQuery as $field) {
                $fieldsSelectedQuery[] = $field->field_name;
            }
            if ($this->processedDinamicRows !== null) {
                $processedDinamicRowsFields = array();
                foreach ($this->processedDinamicRows as $rules) {
                    $dinamicRowsFieldsAnd = explode(" Y ", $rules);
                    foreach ($dinamicRowsFieldsAnd as $keyAndField => $andField) {
                        $orFieldVariables = explode(" O ", $andField);
                        if (count($orFieldVariables) > 1) {
                            $processedDinamicRowsFields = array_merge($processedDinamicRowsFields, $orFieldVariables);
                        } else {
                            $processedDinamicRowsFields[] = $andField;
                        }
                    }
                }
                foreach ($processedDinamicRowsFields as $key => $field) {
                    $processedDinamicRowsFields[$key] = trim(str_replace(")", "", str_replace("(", "", explode("=", $field)[0])));
                }
                $processedDinamicRowsFields = array_unique($processedDinamicRowsFields, SORT_STRING);
                $fieldsSelectedQuery = array_merge($fieldsSelectedQuery, $processedDinamicRowsFields);
            }
            if (count($fieldsSelectedQuery) > 0) {
                $studyStructure = StudyStructure::where('study', $this->study)
                    ->where('field_kind', 'MDC')
                    ->first();
                if (CodingProcessor::codeExists($this->processedRangeInitial, $studyStructure->coding) and
                    CodingProcessor::codeExists($this->processedRangeFinal, $studyStructure->coding)
                ) {

                    $fieldsUniverseStudy = $this->getUniverseStudyFields();
                    $fieldsSelectedQuery = array_merge($fieldsSelectedQuery, $fieldsUniverseStudy);

                    $this->getDataGeneral($fieldsSelectedQuery, $studyStructure);
                    $data = $this->generalDataStudy;
                    if (count($data) > 0) {
                        $data = $this->setDynamicVariables($data);
                        if ($this->processedWithUniverse) {
                            $study = Study::find($this->study);
                            $fieldsUniverse = $this->getUniverseFields($study);
                            $data = $this->setExpansionFactorMobilePeriod($data, $fieldsUniverseStudy, $fieldsUniverse, $study);
                            $data = $this->setExpansionFactorComparativeFields($data, $fieldsUniverseStudy, $fieldsSelectedQuery, $fieldsComparative);

                        } else {
                            $data = $this->setExpansionFactorMobilePeriodNotUniverse($data);
                        }
                        $data = $this->filterDataProcessed($data);
                    }
                }
            }
        }

        return $data;
    }


    public function getDataGeneral($fieldsSelectedQuery, $studyStructure)
    {
        $fieldsSelectedQuery = array_unique($fieldsSelectedQuery);
        $mysqlQuery = "SELECT id, " . implode(', ', $fieldsSelectedQuery) . " FROM " . $this->tableName . " WHERE ";
        $mysqlQuery .= " " . $studyStructure->field_name . " >= " . $this->processedRangeInitial . " AND ";
        $mysqlQuery .= " " . $studyStructure->field_name . " <= " . $this->processedRangeFinal;
        $mysqlQuery .= " AND deleted_at IS NULL";
        $this->generalDataStudy = DB::connection($this->tableConnection)->select($mysqlQuery);
    }

    /**
     * Set the dinamic variables to the data to be processed.
     * @param $data
     * @return
     */
    public function setDynamicVariables($data)
    {

        $dinamicRowsFilters = array();
        foreach ($this->processedDinamicRows as $dinamicVariableName => $rules) {
            $filters = explode(" Y ", $rules);
            foreach ($filters as $key => $rule) {
                $cleanRules = explode(" O ", $rule);
                foreach ($cleanRules as $keyCleanRule => $valueCleanRule) {
                    $cleanRules [$keyCleanRule] = explode("=", trim(str_replace(")", "", str_replace("(", "", $valueCleanRule))));
                }
                $filters[$key] = $cleanRules;
            }
            $dinamicRowsFilters[$dinamicVariableName] = $filters;
        }
        foreach ($data as $keyData => $valueData) {
            foreach ($dinamicRowsFilters as $dinamicVariableName => $filters) {
                $validDataFilter = 1;
                foreach ($filters as $andValidation) {
                    foreach ($andValidation as $orValidation) {
                        $validDataFilterOr = false;
                        if (in_array($orValidation[1], explode(";", $data [$keyData]->{$orValidation[0]}))) {
                            $validDataFilterOr = true;
                            break;
                        }
                    }
                    if ($validDataFilterOr == false) {
                        $validDataFilter = 0;
                        break;
                    }
                }
                $data [$keyData]->{$dinamicVariableName} = $validDataFilter;
            }
        }
        if ($this->processedRows !== null) {
            $this->processedRows = array_merge($this->processedRows, array_keys($dinamicRowsFilters));
        } else {
            $this->processedRows = array_keys($dinamicRowsFilters);
        }
        return $data;
    }

    /**
     * Get get universe study fields
     *
     * @return array
     */
    public function getUniverseStudyFields()
    {
        $fieldsStudy = array();
        $studyStructure = StudyStructure::where('study', $this->study)
            ->whereNotNull('universe')
            ->get();

        foreach ($studyStructure as $field) {
            $fieldsStudy[$field->universe] = $field->field_name;
        }

        ksort($fieldsStudy);
        return $fieldsStudy;
    }

    /**
     * Get get universe fields
     *
     * @param $study
     * @return array .
     */
    public function getUniverseFields($study)
    {
        $fieldsUniverse = array();
        $universeStructure = UniverseStructure::where('universe', $study->universe)->get();
        foreach ($universeStructure as $field) {
            $fieldsUniverse[$field->id] = $field->field_name;
        }
        ksort($fieldsUniverse);
        return $fieldsUniverse;
    }

    /**
     * Set expansion factor in the query result received for mobile period.
     *
     * @param $originalData
     * @param $fieldsUniverseStudy
     * @param $fieldsUniverse
     * @param $study
     * @return array .
     */
    public function setExpansionFactorMobilePeriod($originalData, $fieldsUniverseStudy, $fieldsUniverse, $study)
    {
        $periodField = UniverseStructure::where('universe', $study->universe)
            ->where('field_type', 'M')
            ->first();


        $dataWeighted = array();
        if (!empty($periodField)) {
            $fieldIndexPeriod = array_search($periodField->field_name, $fieldsUniverse);
            unset($fieldsUniverse[$fieldIndexPeriod]);
            unset($fieldsUniverseStudy[$fieldIndexPeriod]);
            $fieldsUniverse = array_values($fieldsUniverse);
            $fieldsUniverseStudy = array_values($fieldsUniverseStudy);

            $universeConcatenated = $this->getUniverseGroupedData($fieldsUniverse, $study, $periodField);
            $universeWeightedData = $this->getWeightedDataUniverse($originalData, $universeConcatenated, $fieldsUniverseStudy);

            if (!empty($universeWeightedData)) {
                foreach ($originalData as $rrn => $data) {
                    $keyStudyUniverse = array();
                    foreach ($fieldsUniverseStudy as $field) {
                        $keyStudyUniverse[] = $data->{$field};
                    }
                    $keyStudyUniverse = implode('-', $keyStudyUniverse);
                    $data->{'@EXPANSION_FACTOR_MOBILE_PERIOD'} = $universeWeightedData[$keyStudyUniverse];
                    $dataWeighted[$rrn] = $data;
                }
            }

        }

        return $dataWeighted;
    }


    /**
     * Set expansion factor in the query result received for mobile period.
     *
     * @param $originalData
     * @return array .
     */
    public function setExpansionFactorMobilePeriodNotUniverse($originalData)
    {
        $dataWeighted = array();

        foreach ($originalData as $rrn => $data) {
            $data->{'@EXPANSION_FACTOR_MOBILE_PERIOD'} = 1;
            $dataWeighted[$rrn] = $data;
        }

        return $dataWeighted;
    }

    /**
     * Get the universe grouped data for generate expansion factor.
     *
     * @param $fieldsUniverse
     * @param $study
     * @param $periodField
     * @return array .
     */
    public function getUniverseGroupedData($fieldsUniverse, $study, $periodField)
    {
        $periodYear = substr($this->processedRangeFinal, 0, 4);
        $universeConcatenated = array();

        if (!empty($study->universe)) {
            $universeGroupedData = " SELECT ";
            $universeGroupedData .= " " . implode(', ', $fieldsUniverse) . " ";
            $universeGroupedData .= " , value AS SAMPLE ";
            $universeGroupedData .= " FROM " . "CT_PRJ_UniverseTable_ID_" . $study->universe;
            $universeGroupedData .= " WHERE " . $periodField->field_name . " = " . $periodYear;
            $universeGroupedData .= " AND deleted_at IS NULL";
            $universeGroupedData = DB::connection('CAMTECH_Dashboard_Projects')
                ->select($universeGroupedData);

            foreach ($universeGroupedData as $data) {
                $sample = $data->SAMPLE;
                unset($data->SAMPLE);
                $universeConcatenated [implode('-', (Array)$data)] = $sample;
            }
        }

        return $universeConcatenated;
    }

    /**
     * Get get weighted data from the universe.
     *
     * @param $originalData
     * @param $universeConcatenated
     * @param $fieldsUniverseStudy
     * @return array .
     */
    public function getWeightedDataUniverse($originalData, $universeConcatenated, $fieldsUniverseStudy)
    {
        $studyConcatenated = array();
        foreach ($originalData as $data) {
            $fieldsUniverse = array();
            foreach ($fieldsUniverseStudy as $field) {
                $fieldsUniverse[] = $data->{$field};
            }
            if (!isset($studyConcatenated [implode('-', $fieldsUniverse)])) {
                $studyConcatenated [implode('-', $fieldsUniverse)] = 1;

            } else {
                $studyConcatenated [implode('-', $fieldsUniverse)] += 1;
            }
        }


        $universeWeightedData = array();
        foreach ($studyConcatenated as $key => $data) {
            if (key_exists($key, $universeConcatenated)) {
                $universeWeightedData[$key] = $universeConcatenated[$key] / $data;
            }

        }
        return $universeWeightedData;
    }

    /**
     * Set expansion factor in the query result received for comparative fields.
     *
     * @param $originalData
     * @param $fieldsUniverseStudy
     * @param $fieldsSelectedQuery
     * @param $fieldsComparative
     * @return array.
     */
    public function setExpansionFactorComparativeFields($originalData, $fieldsUniverseStudy, $fieldsSelectedQuery, $fieldsComparative)
    {
        $dataWeighted = array();
        $universeConcatenated = $this->getUniverseComparativeGroupedData();
        foreach ($fieldsComparative as $key => $field) {
            if (!in_array($field, $fieldsSelectedQuery)) {
                unset($fieldsComparative[$key]);
            }
        }
        if (count($fieldsComparative) > 0) {
            $universeWeightedData = $this->getWeightedComparativeDataUniverse($universeConcatenated, $fieldsUniverseStudy, $fieldsComparative);
            foreach ($originalData as $rrn => $data) {
                $keyStudyUniverse = array();
                foreach ($fieldsUniverseStudy as $field) {
                    $keyStudyUniverse[] = $data->{$field};
                }
                $keyStudyUniverse = implode('-', $keyStudyUniverse);
                foreach ($fieldsComparative as $comparativeField) {
                    $data->{'@EXPANSION_FACTOR_' . $comparativeField} = $universeWeightedData[$keyStudyUniverse][$comparativeField][$data->{$comparativeField}];
                }
                $dataWeighted[$rrn] = $data;
            }
        } else {
            $dataWeighted = $originalData;
        }
        return $dataWeighted;
    }

    /**
     * Get the universe grouped data for generate expansion factor.
     *
     * @return array.
     */
    public function getUniverseComparativeGroupedData()
    {
        $fieldsUniverse = $this->getUniverseComparativeFields();
        $study = Study::find($this->study);

        $universeConcatenated = array();
        if (!empty($study->universe)) {
            $universeGroupedData = " SELECT ";
            $universeGroupedData .= " " . implode(', ', $fieldsUniverse) . " ";
            $universeGroupedData .= " , value AS SAMPLE ";
            $universeGroupedData .= " FROM " . "CT_PRJ_UniverseTable_ID_" . $study->universe;
            $universeGroupedData .= " WHERE deleted_at IS NULL";
            $universeGroupedData = DB::connection('CAMTECH_Dashboard_Projects')
                ->select($universeGroupedData);

            foreach ($universeGroupedData as $data) {
                $sample = $data->SAMPLE;
                unset($data->SAMPLE);
                $universeConcatenated [implode('-', (Array)$data)] = $sample;
            }
        }


        return $universeConcatenated;
    }


    /**
     * Get get universe fields
     *
     * @return array.
     */
    public function getUniverseComparativeFields()
    {
        $study = Study::find($this->study);
        $fieldsUniverse = array();
        $universeStructure = UniverseStructure::where('universe', $study->universe)->get();
        foreach ($universeStructure as $field) {
            $fieldsUniverse[$field->id] = $field->field_name;
        }
        ksort($fieldsUniverse);

        return $fieldsUniverse;
    }

    /**
     * Get comparative fields found in the sample.
     *
     * @return array
     */
    public function getFieldsComparative()
    {
        $fieldsComparative = array();
        $studyStructure = StudyStructure::where('study', $this->study)
            ->where('field_kind', 'CMP')
            ->get();
        foreach ($studyStructure as $field) {
            $fieldsComparative[] = $field->field_name;
        }

        return $fieldsComparative;
    }

    /**
     * Get get weighted data for comparative fields from the universe.
     *
     * @param $universeConcatenated
     * @param $fieldsUniverseStudy
     * @param $fieldsComparative
     * @return mixed.
     */
    public function getWeightedComparativeDataUniverse($universeConcatenated, $fieldsUniverseStudy, $fieldsComparative)
    {
        $studyGroupedData = $this->generalDataStudy;

        $studyConcatenated = array();
        foreach ($studyGroupedData as $data) {
            $keyData = array();
            foreach ($fieldsUniverseStudy as $field) {
                $keyData[] = $data->{$field};
            }
            foreach ($fieldsComparative as $field) {
                if (isset($studyConcatenated [implode('-', $keyData)][$field][$data->{$field}])) {
                    $studyConcatenated [implode('-', $keyData)][$field][$data->{$field}] += 1;
                } else {
                    $studyConcatenated [implode('-', $keyData)][$field][$data->{$field}] = 1;
                }
            }
        }

        $universeWeightedData = array();
        foreach ($studyConcatenated as $keyByVariable => $dataByVariable) {
            foreach ($dataByVariable as $key => $data) {
                foreach ($data as $value => $amount) {
                    if (array_key_exists($keyByVariable, $universeConcatenated)) {
                        $universeWeightedData[$keyByVariable][$key][$value] = $universeConcatenated[$keyByVariable] / $amount;

                    }
                }
            }
        }

        return $universeWeightedData;
    }

    /**
     * Get data filtered from the query result received.
     *
     * @param $originalData
     * @return mixed.
     */
    public function filterDataProcessed($originalData)
    {
        if ($this->processedFilterFields !== null) {
            $fieldsFilterQuery = StudyStructure::where('study', $this->study)
                ->whereIn('id', $this->processedFilterFields)
                ->get();

            $fieldsFilterSelected = [];
            foreach ($fieldsFilterQuery as $field) {
                $fieldsFilterSelected[$field->id] = $field->field_name;

                if (isset($this->processedFilterFieldsValues[$field->id])) {
                    foreach ($this->processedFilterFieldsValues[$field->id] as $key) {
                        $fieldsFilterSelectedValues[$field->id][] = CodingProcessor::getCodeFromId($key, $field->coding);
                    }
                }
            }
            $filterData = [];
            foreach ($originalData as $rrn => $data) {
                $validFilterColumn = 0;
                foreach ($fieldsFilterSelected as $key => $fieldFilter) {
                    if (isset($fieldsFilterSelectedValues[$key])) {
                        /** @var TYPE_NAME $fieldsFilterSelectedValues */
                        foreach ($fieldsFilterSelectedValues[$key] as $filterValue) {
                            $values = explode(';', $data->{$fieldFilter});
                            if (in_array($filterValue, $values)) {
                                $validFilterColumn += 1;
                                break;
                            }
                        }
                    } else {
                        $validFilterColumn += 1;
                    }
                }
                if ($validFilterColumn == count($fieldsFilterSelected)) {
                    $filterData[$rrn] = $data;
                }
            }

            return $filterData;
        }
        return $originalData;
    }

}
