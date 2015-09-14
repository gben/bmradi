<?php

class Helpers {

    public static function get_all_countries() {
        return DB::select('select * from countries_dbx order by id asc limit 10');
    }

    public static function get_all_categories($cat_id = "") {
		$condition = "";
		if(is_numeric($cat_id) && $cat_id > 0){
			$condition = " where id = '".$cat_id."'";
		}
        return DB::select("select * from categories_dbx $condition order by title desc");
    }

    public static function getTotalSubscriptions() {
        $rs = DB::select("select count(*) as value from subscribers where status = 'ACTIVE'");
        return $rs[0]->value;
    }

    public static function getTotalCampaigns($user = false, $status=false) { 
        if ($user && !empty($user) && isset($user)){
			$rs = DB::select('select count(*) as value from tbl_campaigns where user_id = ?', array(Session::get('account_id')));
		}elseif($status && strlen($status) > 1){
            $rs = DB::select('select count(*) as value from tbl_campaigns where campaignstatus = ? and approvalstatus = ?', array($status, 'Approved'));
        }else{
			$rs = DB::select('select count(*) as value from tbl_campaigns where campaignstatus in("Ongoing","Closed") and approvalstatus = ?', array('Approved'));
		}
     
        return $rs[0]->value;
    }

    public static function getTotalClosedCampaigns($is_admin = false, $mystatus = false) {
		if($is_admin){
			if($mystatus){
				$rs = DB::select("select count(*) as value from tbl_campaigns where campaignstatus = ? and closingstatus = ?", ["Closed", $mystatus]);
			}else{
				$rs = DB::select("select count(*) as value from tbl_campaigns where campaignstatus = 'closed'");
			}
			
		}else{
			$rs = DB::select("select count(*) as value from tbl_campaigns where user_id = ? and campaignstatus = 'closed'", array(Session::get("account_id")));
		}
        return $rs[0]->value;
    }

    public static function getTotalShelvedCampaigns() {
        $rs = DB::select("select count(*) as value from tbl_campaigns where user_id = ? and campaignstatus = 'shelved'", array(Session::get("account_id")));
        return $rs[0]->value;
    }

    public static function getTotalOngoingCampaigns() {
        $rs = DB::select("select count(*) as value from tbl_campaigns where user_id = ? and campaignstatus = 'ongoing'", array(Session::get("account_id")));
        return $rs[0]->value;
    }

    public static function getTotalInvestors() {
        $rs = DB::select("select count(*) as value from accounts_dbx where account_type='INVESTOR'");
        return $rs[0]->value;
    }

    public static function getTotalEntrepreneurs() {
        $rs = DB::select("select count(*)  as value from accounts_dbx where account_type='ENTREPRENEUR'");
        return $rs[0]->value;
    }

    public static function hasPermission($permission, $item) {
        switch (strtoupper($item)) {
            case "SELECT": //Select
                $res = DB::select("SELECT id FROM permission WHERE id IN (SELECT permission FROM permissionmap 
                        WHERE role IN (SELECT role FROM rolemap WHERE USER = ?)) AND title = ?", array(Session::get('account_id'), strtolower($permission . '.select.permission')));
                break;
            case "INSERT": //Insert
                $res = DB::select("SELECT id FROM permission WHERE id IN (SELECT permission FROM permissionmap 
                        WHERE role IN (SELECT role FROM rolemap WHERE USER = ?)) AND title = ?", array(Session::get('account_id'), strtolower($permission . '.insert.permission')));
                break;
            case "UPDATE": //Update
                $res = DB::select("SELECT id FROM permission WHERE id IN (SELECT permission FROM permissionmap 
                        WHERE role IN (SELECT role FROM rolemap WHERE USER = ?)) AND title = ?", array(Session::get('account_id'), strtolower($permission . '.update.permission')));
                break;
            case "DELETE": //Delete
                $res = DB::select("SELECT id FROM permission WHERE id IN (SELECT permission FROM permissionmap 
                        WHERE role IN (SELECT role FROM rolemap WHERE USER = ?)) AND title = ?", array(Session::get('account_id'), strtolower($permission . '.delete.permission')));
                break;
            default://Access to the url
                $res = DB::select("SELECT id FROM permission WHERE id IN (SELECT permission FROM permissionmap 
                        WHERE role IN (SELECT role FROM rolemap WHERE USER = ?)) AND url = ?", array(Session::get('account_id'), strtolower($permission)));
                break;
        }
        if (count($res) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Generate Grid function
     */

    public static function generateGrid($parameters) {
        extract($parameters);
        /*
         * $columns = Helper::getColumns($countries[0]);
          echo count($columns);
         */

        $gridComponent = '';
        #Generate Grid Div's
        $gridComponent .= "<div id='gridForm' class='gridContent' style='display:none'></div><div id='loadingAdd' style='display:none'></div>";
        #New Grid start
        $gridComponent .= "<div id='gridTable' class='row'>
                            <div class='col-xs-12'>
                                <div class='box'>";
        #Grid Header element  
        $outOf = (Session::get('rec_per_page') * (Input::get('page') == 0 ? 1 : Input::get('page')));
        $outOf = $outOf > $total_pages ? $total_pages : $outOf;
        $gridComponent .= "<div class='box-header'>
                            <h3 class='box-title'>" . ucwords($title) . " ( " . $outOf . " of $total_pages )</h3>
                            <div class='box-tools'><form action='" . URL::current() . "' method='get'>
                                <div class='input-group'>
                                    <input type='text' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' 
                                    " . (Input::get('table_search') != '' ? "value='" . Input::get('table_search') . "'" : "") . " />
                                    <div class='input-group-btn'>
                                        <button class='btn btn-sm btn-default' type='submit'><i class='fa fa-search'></i></button>
                                    </div>
                                </div></form>
                            </div>";
        #Generate Filters
        $gridComponent .= Helpers::getFilter($filters);

        $gridComponent .= "</div><!-- /.box-header -->";
        if ($total_pages > 0) {
            $columns = Helper::getColumns($data[0]);
            $token = Form::token();
            $gridComponent .= "<div class='box-body table-responsive no-padding'>";
            $gridComponent .= "$token    
                                    <table class='table table-hover' id='" . ($isReport ? "report" : "listing") . "' title='" . $view . "'><tbody>";
            #Beginning of column headers
            $gridComponent .= "<tr class='gridColumns gradientSilver'>";
            $headerCount = 0;
            if ($checkbox) {
                $gridComponent .= "<th class='column'><input type='checkbox' name='primarykey[]' value='all'/></th>";
                $headerCount = 1;
            }
            if ($col_number) {
                $gridComponent .= "<th class='column'>#</th>";
                $headerCount = $headerCount + 1;
            }
            if ((strtoupper($view) == 'INVESTOR' || strtoupper($view) == 'ENTREPRENEUR')) { //|| $isReport
                $gridComponent .= "<th class='column'>View Profile</th>";
                $headerCount = $headerCount + 1;
            }


            #Generate extra headers from column names
            $row = 0;
            $col_titles = array();
            for ($i = 1; $i < count($columns); $i++) {
                $gridComponent .= "<th class='column'>" . str_replace("*", '<i class="fa fa-filter"></i>', ucwords(str_replace("_", " ", $columns[$i]))) . "</th>";
            }
            if ($view == 'campaigns' && strtoupper(Session::get('account_type')) == 'ENTREPRENEUR') { //|| $isReport
                $gridComponent .= "<th class='column'></th>";
                $headerCount = $headerCount + 1;
            }
            $headerCount = $headerCount + count($columns);
            /* foreach($columns as $col)
              {
              $gridComponent .= "<th>" . ucfirst($col) . "</th>";
              } */
            $gridComponent .= "</tr>";
            /** End of table header * */
            $col_count = 0;
            $colNO = count($columns);
            #Generate grid row details
            foreach ($data as $data_item) {
                $gridComponent .= "<tr class='gridContentRecord' title='" . $data_item->$columns[0] . "'>";
                if ($checkbox) {
                    $gridComponent .= "<td class='grid1of10'><input type='checkbox' name='primarykey[]' value='" . $row[0] . "'/></td>";
                }
                if ($col_number) {
                    $col_count +=1;
                    $gridComponent .= "<td>$col_count</td>";
                }
                if ((strtoupper($view) == 'INVESTOR' || strtoupper($view) == 'ENTREPRENEUR')) { //|| $isReport
                    $u = URL::route('view_profile', array(
                                'acc' => $data_item->primarykey
                            ));
                    $html = HTML::link($u, 'View');
                    $gridComponent .= "<td>$html</td>";
                }
                for ($i = 1; $i < $colNO; $i++) {
                    $statusTd = '';
                    if (strtoupper($columns[$i]) == 'STATUS' || strtoupper($columns[$i]) == 'SUBSCRIPTION_STATUS') {
                        if ($data_item->$columns[$i] == '1' || strtoupper($data_item->$columns[$i]) == 'ACTIVE') {
                            $statusTd = '<span class="label label-success">Active</span>';
                        } else {
                            $statusTd = '<span class="label label-danger">Inactive</span>';
                        }
                    }
                    $gridComponent .= "<td>" . ($statusTd == '' ? $data_item->$columns[$i] : $statusTd) . "</td>";
                }
                if ($view == 'campaigns' && strtoupper(Session::get('account_type')) == 'ENTREPRENEUR') {
                    $col_count +=1;
                    $gridComponent .= "<td>" . Helpers::getCampaignAppAction($data_item->$columns[0]) . "</td>";
                }
                $gridComponent .= "</tr>";
                if ($isReport) {
                    $gridComponent .= "<tr title='" . $data_item->$columns[0] . "'>
                                <td colspan='$headerCount'>
                                        <div id='loading" . $data_item->$columns[0] . "' class='loadingview'></div>
                                        <div id='ajaxcontent" . $data_item->$columns[0] . "'>
                                        </div>
                                </td>
                            </tr>";
                }
            }
            $pagination = Paginator::make($data, $total_pages, Session::get('rec_per_page')); //->paginate(Session::get('rec_per_page'))
            $paginationString = $pagination->links();
            $gridComponent .= "</tbody></table>
                                </div><!-- /.box-body -->                                
                            </div><!-- /.box -->
                        </div>
                        <div class='custom_pagination'>$paginationString</div>
                    </div>";
        } else {
            $gridComponent .= "<div style='color:red;font-size:18px;padding: 20px'>" . (Input::get('table_search') != '' ? "No match found for <b>" . Input::get('table_search') . "</b>" : " No records") . "</div></div><!-- /.box -->
                        </div>
                    </div>";
        }
        return $gridComponent;
    }

    public static function getFilter($filterArray) {
        /*
         * Filter HTML Start
         */

        $datefrom = '';
        $dateto = '';
        $active_status = '';
        $cp_status = '';
        $inv_status = '';
        if (Session::get('FilterArray') != '') {
            if (Session::get('filterPage') == URL::current())
                extract(Session::get('FilterArray'));
            else
                Session::put("FilterArray", '');
        }
        Session::put('filterPage', URL::current());

        $filter_resp = "<div style='float: left;margin-bottom: 5px;text-align: center;width: 100%'><form method='GET'>";
        foreach ($filterArray as $filter) {
            switch (strtoupper($filter)) {
                case "DATE":
                    $filter_resp .= " From: <input type='text' name='datefrom' id='datefrom' class='datefilter input' value='" . $datefrom . "'/>  To: <input type='text' name='dateto' id='dateto' class='datefilterto input' value='" . $dateto . "'/>";
                    break;
                case "CAMPAIGNS":
                    $filter_resp .= Helpers::createSelect("cp_status", array('ongoing', 'closed', 'published', 'shelved'), 'Select Campaign Status', $cp_status);
                    break;
                case "INVESTORS":
                    $filter_resp .= Helpers::createSelect("inv_status", array('invested', 'dormant'), 'Select Investement Status', $inv_status);
                    break;
                case "ACTIVE_STATUS":
                    $filter_resp .= Helpers::createSelect("active_status", array('active', 'inactive'), 'Select Status', $active_status);
                    break;
                default:
                    break;
            }
        }
        /*
         * Filter HTML End
         */
        if (strpos($filter_resp, 'input') !== false)
            $filter_resp .= Form::token() . '&nbsp;<button class="btn btn-sm btn-default" type="submit"><i class="fa fa-filter"></i></button>
                        </form></div>';
        else
            $filter_resp = '';

        return $filter_resp;
    }

    public static function createSelect($name, $data, $default = '', $selected) {
        $resp = "&nbsp;<select name='$name' class='input input-sm '>";
        if (!empty($default)) {
            $resp .= "<option value=''>$default</option>";
        }
        foreach ($data as $d) {
            $resp .= "<option value='$d' " . (strtoupper($d) == strtoupper($selected) ? 'selected' : '') . ">$d</option>";
        }
        $resp .="</select>&nbsp;&nbsp;";
        return $resp;
    }

    /*
     * Get Resultset columns
     */

    public static function getColumns($resultset) {
        $columns = array();
        foreach ($resultset as $key => $value) {
            $columns[] = $key;
        }
        return $columns;
    }

    /*
     * Fetch Parameter function
     */

    public static function getGlobalValue($parameter) {
        $rs = DB::table("system_params")->where("parameter", '=', $parameter)->get(array("value"));
        return $rs[0]->value;
    }

    /*
     * simple log data
     */

    public static function logData($data) {
        DB::table('logs')->insert(
                array(
                    'data' => $data));
    }

    /*
     * Get Respective Campaign Action
     */

    public static function getCampaignAction($campaignID) {
        if (strtoupper(Session::get("account_type")) == 'ENTREPRENEUR') {
            $u = URL::route('campaign_info', array(
                        'campaign' => Helper::getUniqueCampaignID($campaignID)
                    ));
            $html = HTML::link($u, 'Edit');
        }
        return $html;
    }

    public static function isCampaignComplete($id) {
        $rs = DB::select("SELECT Count(tab_id) as tabs from mradi_campaign_progress where campaign_id = ?", array($id));
        if ($rs[0]->tabs == 9)
            return true;
        else
            return false;
    }

    public static function isNewCampaign($campaignID, $stage) {
        switch ($stage) {
            case '1':
                $rs = DB::select("SELECT id from tbl_campaign_summary where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '2':
                $rs = DB::select("SELECT id from tbl_campaign_companyinfo where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '3':
                $rs = DB::select("SELECT id from tbl_campaign_market where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '4':
                $rs = DB::select("SELECT id from tbl_campaign_proposal where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '5':
                $cnt = DB::select("SELECT id, count(id) as tcount from tbl_campaign_team where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                $rs = $cnt;// = ($cnt[0]->tcount) == 5 ? $cnt : array();
                break;
            case '6':
                $rs = DB::select("SELECT id from tbl_campaign_summary_stmnt where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '7':
                $rs = DB::select("SELECT id from tbl_campaign_summary where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '8':
                $rs = DB::select("SELECT id from tbl_campaign_summary where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            case '9':
                $rs = DB::select("SELECT id from tbl_campaign_video where campaign_id = ?", array(Helpers::getCampaignID($campaignID)));
                break;
            default:
                break;
        }
        if (count($rs) > 0){
			//error_log("count is beyond 0 -- " . count($rs));
            return false;
        }else{
			//error_log("count is " . count($rs));
            return true;
		}
    }

    public static function getUniqueCampaignID($campaignID) {
        $rs = DB::select("SELECT uniqueid from tbl_campaigns where id = ?", array($campaignID));
        return $rs[0]->uniqueid;
    }

    public static function getCampaignID($ID, $name = false, $details = false) {
        $rs = DB::select("SELECT id,campaigname, user_id, campaignstatus from tbl_campaigns where uniqueid = ?", array($ID));
        if ($name){
            return $rs[0]->campaigname;
        }elseif($details){
            return $rs[0];
		}else{
			return $rs[0]->id;
		}
    }

    public static function getCampaignSummary($campaignID) {
        $rs = DB::select("SELECT ts.* from tbl_campaign_summary ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }

    public static function getCampaignDetails($campaignID) {
        $rs = DB::select("SELECT cn.id AS country_name,ts.* FROM tbl_campaign_companyinfo ts
                LEFT JOIN tbl_campaigns tc ON ts.campaign_id = tc.id 
                LEFT JOIN  countries_dbx cn ON BINARY ts.country_of_ops = BINARY cn.code  WHERE tc.uniqueid =  ?", array($campaignID));
        return $rs;
    }

    public static function getMarketInfo($campaignID) {
        $rs = DB::select("SELECT ts.* from tbl_campaign_market ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }

    public static function getCampaignProposal($campaignID) {
        $rs = DB::select("SELECT ts.* from tbl_campaign_proposal ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }

    public static function getSummaryStatement($campaignID) {
        $rs = DB::select("SELECT ts.* from tbl_campaign_summary_stmnt  ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }
    
    public static function getFinancialStatement($campaignID) {
        $rs = DB::select("SELECT tf.* from tbl_campaign_financials  tf left join tbl_campaigns tc on tf.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }

    public static function getTeamDetails($campaignID) {
        $rs = DB::select("SELECT ts.*, count(*) as 'team_count' from tbl_campaign_team  ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }
    
    public static function getTeamList($campaignID) {
        $rs = DB::select("SELECT ts.* from tbl_campaign_team  ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        /*$pageNumber = Input::get('page', 1);
		$perpage = 1;
			
		$slice = array_slice($rs, $perpage * ($pageNumber - 1), $perpage);
		$rs = Paginator::make($slice, count($rs), $perpage);*/
        return $rs;
    }

    public static function getVideoContent($campaignID) {
        $rs = DB::select("SELECT ts.* from tbl_campaign_video  ts left join tbl_campaigns tc on ts.campaign_id = tc.id  where tc.uniqueid = ?", array($campaignID));
        return $rs;
    }

    public static function progressCampaign($campaignID, $tab) {
        $campaignID = Helpers::getCampaignID($campaignID);
        $rs = DB::select("Select ID from mradi_campaign_progress where campaign_id = ? and tab_id = ?", array($campaignID, $tab));
        if (count($rs) <= 0) {
            DB::table('mradi_campaign_progress')->insert(array(
                'campaign_id' => $campaignID,
                'tab_id' => $tab));
        }
    }

    public static function isCampaignNameUnique($campaigname) {
        $rs = DB::select("SELECT campaigname from tbl_campaigns where campaigname = ?", array($campaigname));
        if (count($rs) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function getUniqueID() {
        return md5(uniqid('mradi', true));
    }

    /*
     * @getFiles - array($parameters)
     * $name - name of file input
     * $no_files - number of files
     * $ref - file reference
     * $download - false;listing true;downloadable
     */

    public static function getFiles($parameters) {
        $response = '';
        if ($parameters['download'] == true) {
            $files = Helpers::getUploadedFileDetails($parameters['ref']);
            foreach ($files as $file) {
                $response .= HTML::link("/download/" . $file->file_alias, " " . $file->file_name, array('class' => 'fa fa-download'));
            }
        } else {
            $no_files = ($parameters['no_files'] == '' ? 1 : $parameters['no_files']);
            if ($parameters['ref'] != '') { //Show uploaded files
                $files = Helpers::getUploadedFileDetails($parameters['ref']);
                foreach ($files as $file) {
                    $response .= HTML::link("/remove/" . $parameters['ref'] . "/" . $file->file_alias, " " . $file->file_name, array('class' => 'fa fa-cut')) . '<br/>';
                }
                for ($i = count($files); $i < $no_files; $i++) { //List available files
                    $response .= '<div class="form-group ">' .
                            Form::file($parameters['name'] . '[]', array("accept" => "image/*", "class" => "form-control")) .
                            '</div>';
                }
            } else {
                for ($i = 0; $i < $no_files; $i++) { //List available files
                    $response .= '<div class="form-group">' .
                            Form::file($parameters['name'] . '[]', array("accept" => "image/*", "class" => "form-control")) .
                            '</div>';
                }
            }
        }
        return $response;
    }

    public static function removeFile($file_ref, $file_name, $file) {
        unlink($file);
        DB::table('mradi_upload_details')
                ->where('campaign_ref', $file_ref)
                ->where('file_alias', $file_name)
                ->delete();
    }

    public static function uploadCampaignFile($files, $reference) {
        if (count($files) > 0 ) {
//            if(Input::hasFile($files[0]))
//                {
            //foreach ($files as $fileInput) {error_log("image upload 12");
                if(isset($files))
                {
					$file_alias = Helpers::getUniqueID() . "_" . $files->getClientOriginalName();
					$files->move(storage_path() . "/campaigns", $file_alias);
					Helpers::uploadFileData($reference, $files->getClientOriginalName(), $file_alias);
                }
            //}
        }
    }

    public static function uploadFileData($ref, $original_file_name, $file_alias, $update = false) {
        if (!$update) {
            DB::table('mradi_upload_details')->insert(
                    array('campaign_ref' => $ref,
                        'file_name' => $original_file_name,
                        'file_alias' => $file_alias)
            );
        } else {
            DB::table('mradi_upload_details')->where('campaign_ref', $ref)->update(
                    array(
                        'file_name' => $original_file_name,
                        'file_alias' => $file_alias)
            );
        }
    }

    public static function getUploadedFileDetails($file_ref) {
        return DB::select("SELECT * FROM mradi_upload_details WHERE campaign_ref = ? and file_name is not null and file_alias is not null order by id desc limit 1 ", array($file_ref));
    }

    public static function getImageContentType($file) {
        $mime = exif_imagetype($file);

        if ($mime === IMAGETYPE_JPEG)
            $contentType = 'image/jpeg';

        elseif ($mime === IMAGETYPE_GIF)
            $contentType = 'image/gif';

        else if ($mime === IMAGETYPE_PNG)
            $contentType = 'image/png';
        else
            $contentType = false;

        return $contentType;
    }

    public static function generateCampaignGridList($parameters = array(), $mystatus=false) {
        extract($parameters);
        $gridComponent = '<div class="">
                            <div class="row" style="margin: 0 auto;">';
        $category = (Input::get('categories_list') != 'All' || Input::get('categories_list') != '0') ? Input::get('categories_list') : '';
        if($mystatus && strlen($mystatus) > 0){
			$recent_campaigns = Campaign::get_campaigns($category, $mystatus);
		}else{
			$recent_campaigns = Campaign::get_campaigns($category);
		}
        
        foreach ($recent_campaigns as $item) {

            $file = Helpers::getUploadedFileDetails($item->listing_logo);
            if (empty($file))
                $image = 'no-image.png';
            else
                $image = $file[0]->file_alias;
            $u = URL::route('campaigns_grid_info', array(
                        'campaign' => $item->uniqueid
                    ));

            $moreInfo = HTML::link($u, '...view more', array("class" => ""));
            $gridComponent .=" <div class='campaign_holder campaign_holder' style='height: auto !important;'>
                            " . HTML::image("/assets/$image", $item->campaigname . ' campaign logo', array("height" => "180px", "width" => "100%")) . "
                            <div class=''>
                            <div class='panel-body'>
                            <div style='color: #57A0C9;'>
                                <h4>$item->campaigname</h4>
                                <!--<div class=\"progress\">
                                    <div class=\"progress-bar progress-bar-warning\" role=\"progressbar\" aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: percentage_share_completion;\">
                                        <span class=\"sr-only\">percentage_share_completion Complete</span>
                                    </div>
                                </div>-->
                            </div>
                                </div>
                                <div class=\"panel-footer\" style='height: 100px;'>
                                    " . substr($item->business_summary, 0, 100) . $moreInfo . "
                                </div>
                                <!--<div class=\"panel-footer\" style='height: 100px;'>
                                    <h5>item->no_of_shares Shares </h5>
                                    <h6>item->no_of_shares - item->share_bought Remaining |  Days Remaining</h6>
                                </div>-->
                            </div>                 
                        </div>";
        }
        if (count($recent_campaigns) == 0) {
            $gridComponent .= '<br/><br/><div class="callout callout-warning">
                                        <h4>No campaigns found under category selected</h4>
                                    </div>';
        }
        $gridComponent .= '</div>
                            </div>';
        return $gridComponent;
    }

    public static function logEmailMessage($parameters = array(), $sent = false) {
        extract($parameters);
        DB::table('mradi_outbox_email_log')->insert(
                array(
                    'sender' => $sender,
                    'recipient' => $recipient,
                    'message' => $message,
                    'subject' => $subject,
                    'status' => ($sent ? 'SENT' : ''),
                    'message_type' => $source,
                    'date_sent' => date('Y-m-d H:i:s'),
                    'sent_status' => ($sent ? '1' : '0')
        ));
    }

    public static function logAction($action, $auth = true) {
        DB::table('mradi_audit_trail_log')->insert(
                array(
                    'user' => (!$auth ? 'Anonymous' : Session::get('username') . " - " . Session::get('fullnames')),
                    'action' => $action
        ));
    }

    public static function CheckChangePassword() {
        $results = DB::select('select * from accounts_dbx where change_password = 0 and account_id = ?', array(Session::get('account_id')));

        if (empty($results)) {
            return false;
        } else {
            return true;
        }
    }

    public static function passedTest() {
        $results = DB::select("select * from accounts_dbx where passed_test = 'YES' and account_id = ?", array(Session::get('account_id')));

        if (empty($results)) {
            return false;
        } else {
            return true;
        }
    }

    public static function isAnsCorrect($question, $answer) {
        $rs = DB::select("SELECT * FROM answers WHERE correct = 'YES' AND answer_id = ? AND question_id = ?", array($answer, $question));
        if (empty($rs))
            return false;
        else
            return true;
    }

    public static function getFailed($question) {
        $rs = DB::select("SELECT que_present FROM questions WHERE id = ?", array($question));
        if (empty($rs))
            return 0;
        else
            return $rs[0]->que_present;
    }

    public static function profileComplete() {
        $rs = DB::select("SELECT * FROM mradi_accounts_profile WHERE account_id = ?", array(Session::get('account_id')));
        if (empty($rs))
            return false;
        else
            return true;
    }

    public static function getProfileDetails($account_id = '') {
        $rs = DB::select("SELECT ts.*,tc.date_of_birth,tc.id_passport,tc.pin_number,tc.address,tc.description,tc.location,tc.profile_pic FROM accounts_dbx ts LEFT JOIN mradi_accounts_profile tc ON ts.account_id = tc.account_id  
        WHERE tc.account_id =?", array(($account_id == '' ? Session::get("account_id") : $account_id)));
        
        return $rs;
    }
    
    public static function getCampaignAppAction($campaignID, $edit = false) {

        $actions_content = '';
        $c_id = Helpers::getUniqueCampaignID($campaignID);
        $rs = DB::Select("SELECT campaignstatus,approvalstatus FROM tbl_campaigns WHERE id = ?", array($campaignID));
        /*
         * Edit and Rejected Options for Entre
         */
        if ((!Helpers::isCampaignComplete($campaignID)) && strtoupper(Session::get('account_type')) == 'ENTREPRENEUR' && !$edit) {
            $actions_content .= '<li>' . Helpers::getCampaignAction($campaignID) . '</li>';
        }//View for Entre on all to publish
        elseif (Helpers::isCampaignComplete($campaignID) && strtoupper($rs[0]->approvalstatus) == 'PENDING' && strtoupper($rs[0]->campaignstatus) != 'PUBLISHED' && Session::get('account_type') == 'ENTREPRENEUR') {
            $actions_content .= (!$edit ? '<li>' . Helpers::getCampaignAction($campaignID) . '</li>' : '') . '<a href="javascript:submitAction(\'' . URL() . '/campaign/Publish/' . $c_id . '\')" class="Cpcomment">Publish</a>
                                </li>';
        }//View for Admin on all to publish
        elseif (Helpers::isCampaignComplete($campaignID) && strtoupper($rs[0]->approvalstatus) == 'PENDING' && strtoupper($rs[0]->campaignstatus) == 'PUBLISHED' && Session::get('account_type') == 'ADMIN') {
            $actions_content .= '<li><a href="javascript:submitAction(\'' . URL() . '/campaign/Approve/' . $c_id . '\')" class="Cpcomment">Approve</a></li>
                                <li><a href="javascript:submitAction(\'' . URL() . '/campaign/Reject/' . $c_id . '\')" class="Cpcomment">Mark for review</a></li>
                                <li><a href="javascript:submitAction(\'' . URL() . '/campaign/Deactivate/' . $c_id . '\')" class="Cpcomment">Reject</a></li>';
        } else {
            $actions_content = '';
        }
        if ($actions_content != '') {
            $actions = '<div class="btn-group">
            <button type="button" class="btn btn-warning btn-flat btn-sm">Campaign Action</button>
            <button type="button" class="btn btn-warning btn-flat dropdown-toggle btn-sm" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">';
            $actions .= $actions_content . '</ul></div>';
        } else {
            $actions = '<div style="height:29px"></div>';
        }
        return $actions;
    }

    public static function sendMail($emailData, $template) {
		if(!$template){
			Session::flash('email_names', $emailData['names']);
			Session::flash('email_message', $emailData['message']);
			Session::flash('campaign_status', $emailData['status']);
			$data = array(
				'messages' => ""
			);
			/*
			 * Send Login Email details and Log
			 */
			if (Mail::send('emails.status_notification', $data, function($message)use($emailData) {
								$message->to($emailData['to'], $emailData['names'])->subject('MradiFund Campaign Status Changed');
							})) {
				Helpers::logEmailMessage(
						array(
					"sender" => Helpers::getGlobalValue('SYSTEM_EMAIL'),
					"recipient" => $emailData['to'],
					"message" => $emailData['message'],
					"subject" => "Mradi Account3",
					"source" => 'System'), true);
			}
		}else{
			Session::flash('email_names', $emailData['names']);
			Session::flash('email_message', $emailData['message']);
			//Session::flash('campaign_status', $emailData['status']);
			$data = array(
				'messages' => ""
			);
			//Send tempalte download link
			if (Mail::send('emails.notice', $data, function($message)use($emailData) {
								$message->to($emailData['to'], $emailData['names'])->subject('MradiFund Financials Template');
							})) {
				Helpers::logEmailMessage(
						array(
					"sender" => Helpers::getGlobalValue('SYSTEM_EMAIL'),
					"recipient" => $emailData['to'],
					"message" => $emailData['message'],
					"subject" => "MradiFund Financials",
					"source" => 'System'), true);
			}
		}
    }

    public static function getConversationList() {
        $user_ID = Session::get("account_id");
        $conversations = "<div id='gridForm' class='gridContent' style='display:none'></div><div id='loadingAdd' style='display:none'></div>";
        $conversations .= '<div class="table-responsive">
                                <!-- THE MESSAGES -->
                                ' . Form::token() . '<table class="table table-mailbox" id="report" title="conversation">';
        $rs = Conversation::getConversationList($user_ID);
        $conversations .= "<tr title=''>
                                <td colspan='5'>
                                </td>
                            </tr>";
        if (count($rs['records']) > 0)
            foreach ($rs['records'] as $conv) {
                $conversations .= '<tr ' . (Conversation::getMsgStatus($conv->message_hash) == 0 ? 'class="unread"' : 'class="read"') . ' title="' . $conv->message_hash . '" >
                                        <td class="small-col"><input type="checkbox" /></td>
                                        <td>' . (Conversation::getMsgStatus($conv->message_hash) == 0 ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>') . '</td>
                                        <td>' . ($conv->sender_id == Session::get('account_id') ? $conv->recipient : $conv->sender) . '</td>
                                        <td>(' . Conversation::getMsgCount($conv->message_hash) . ') unread messages</td>
                                        <td>' . $conv->time_sent . '</td>
                                    </tr>';
                $conversations .= "<tr title='" . $conv->message_hash . "'>
                                <td colspan='5'>
                                        <div id='loading" . $conv->message_hash . "' class='loadingview'></div>
                                        <div id='ajaxcontent" . $conv->message_hash . "'>
                                        </div>
                                </td>
                            </tr>";
            }
            else
            {
                $conversations .= "<tr title='d'>
                                <td colspan='5' style='text-align:center'>
                                    No conversations 
                                </td>
                            </tr>";
            }
        $pagination = Paginator::make($rs['records'], $rs['total_pages'], Session::get('rec_per_page'));
        $paginationString = $pagination->links();

        $conversations .= '</table>
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        ' . $paginationString . '
                                            </div>
                                </div><!-- box-footer -->
                            </div><!-- /.table-responsive -->';

        return $conversations;
    }
    public static function getAllConversationList() {
        $user_ID = Session::get("account_id");
        $conversations = "<div id='gridForm' class='gridContent' style='display:none'></div><div id='loadingAdd' style='display:none'></div>";
        $conversations .= '<div class="table-responsive">
                                <!-- THE MESSAGES -->
                                ' . Form::token() . '<table class="table table-mailbox" id="report" title="conversations">';
        $rs = Conversation::getConversationList($user_ID,true);
        $conversations .= "<tr title=''>
                                <td colspan='5'>
                                </td>
                            </tr>";
        if (count($rs['records']) > 0)
            foreach ($rs['records'] as $conv) {
                $conversations .= '<tr ' . (Conversation::getMsgStatus($conv->message_hash) == 0 ? 'class="unread"' : 'class="read"') . ' title="' . $conv->message_hash . '" >
                                        <td class="small-col"></td>
                                        <td>' . (Conversation::getMsgStatus($conv->message_hash) == 0 ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>') . '</td>
                                        <td colspan="3"><b>' . $conv->recipient .'</b> ('. $conv->recipient_email .') & <b>' . $conv->sender . '</b> ('. $conv->sender_email .')</td>
                                        
                                    </tr>';
                $conversations .= "<tr title='" . $conv->message_hash . "'>
                                <td colspan='5'>
                                        <div id='loading" . $conv->message_hash . "' class='loadingview'></div>
                                        <div id='ajaxcontent" . $conv->message_hash . "'>
                                        </div>
                                </td>
                            </tr>";
            }
            else
            {
                $conversations .= "<tr title='d'>
                                <td colspan='5' style='text-align:center'>
                                    No conversations 
                                </td>
                            </tr>";
            }
        $pagination = Paginator::make($rs['records'], $rs['total_pages'], Session::get('rec_per_page'));
        $paginationString = $pagination->links();

        $conversations .= '</table>
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        ' . $paginationString . '
                                            </div>
                                </div><!-- box-footer -->
                            </div><!-- /.table-responsive -->';

        return $conversations;
    }
    
    public static function investorBalance($user_id, $is_admin = false, $campaign_id = false){
		if($is_admin){
			$trans = DB::select(DB::raw("select sum(mws.balance) as balance from mradiwallettransactions mws
						inner join 
						(select max(id) as tid, user_id from mradiwallettransactions group by user_id order by tid desc) drv 
						on mws.id = drv.tid"));
			$trans_balance = $trans ? $trans[0]->balance : 0;
		}elseif($campaign_id && $campaign_id > 0){
			$trans = Mradiwallettransaction::Where('campaign_id','=',$campaign_id)->orderBy('id', 'desc')->first();
			$trans_balance = $trans ? $trans->balance : 0;
		}else{
			$trans = Mradiwallettransaction::Where('user_id','=',$user_id)->orderBy('id', 'desc')->first();
			$trans_balance = $trans ? $trans->balance : 0;
		}
		
		return $trans_balance;
	}
	
	public static function getinvestorDetails($user_id){
		$rs = DB::select("SELECT * from accounts_dbx where account_id = ?", array($user_id));
        return $rs[0];
	}
	
	public static function getBidded($investor_id, $campaign_id){
		$bidded = Mradicampaignbid::Where('campaign_id','=',$campaign_id)
					->Where('investor_id','=',$investor_id)
					->orderBy('id', 'desc')
					->first();
		return $bidded;
	}
	
	public static function getTotalBidded($campaign_id){		
		$bidded = Mradicampaignbid::Where('campaign_id','=',$campaign_id)
					->orderBy('id', 'desc')
					->first();
		return $bidded;
	}
	
	public static function getTotalInvestment($campaign_id){		
		$investment = Helpers::getCampaignProposal($campaign_id);
		return $investment;
	}
	
	public static function getOngoingCampaigns($user_id){
		$rs = DB::select("select id, campaigname from tbl_campaigns where user_id = ? and LOWER(campaignstatus) = 'ongoing' and LOWER(approvalstatus) = 'approved' ", array($user_id));
        return $rs;
	}
	
	public static function getCampaignStatus($campaign_id){
		$rs = DB::select("select id, campaigname, campaignstatus from tbl_campaigns where uniqueid = ? ", array($campaign_id));
        return $rs[0];
	}
	
	public static function getTotalInvestorBid($account_id, $status=false, $isadmin = false){
		if($status){
			if(strtolower(session::get('account_type')) == 'investor' || strtolower(session::get('account_type')) == 'entrepreneur'){
				$res = DB::select("select count(mradicampaignbids.id) AS 'count', sum(Amount) as 'amount', tbl_campaigns.campaignstatus from tbl_campaigns inner join mradicampaignbids on tbl_campaigns.uniqueid = mradicampaignbids.campaign_id where mradicampaignbids.".strtolower(session::get('account_type'))."_id = ? AND LOWER(tbl_campaigns.campaignstatus) = ? GROUP BY tbl_campaigns.campaignstatus", array($account_id, 'ongoing'));
			}else{
				$res = DB::select("select count(mradicampaignbids.id) AS 'count', sum(Amount) as 'amount', tbl_campaigns.campaignstatus from tbl_campaigns inner join mradicampaignbids on tbl_campaigns.uniqueid = mradicampaignbids.campaign_id where LOWER(tbl_campaigns.campaignstatus) = ? GROUP BY tbl_campaigns.campaignstatus", array('ongoing'));
			}
			$bidded = $res;
		}else{
			if($account_id != "guest" && (strtolower(session::get('account_type')) == 'investor' || strtolower(session::get('account_type')) == 'entrepreneur')){
				$bidded = Mradicampaignbid::Where(strtolower(session::get('account_type')).'_id', $account_id)
					->Where('mraditransactiontype_id', '2');
			}else{
				if($isadmin){
					$acctType = Helpers::getinvestorDetails($account_id)->account_type;
					$bidded = Mradicampaignbid::Where(strtolower($acctType).'_id', $account_id)
					->Where('mraditransactiontype_id', '2');
				}else{
					$bidded = Mradicampaignbid::Where('mraditransactiontype_id', '2');
				}
			}
		}
		
		return $bidded;
	}
	
	public static function getTemplate($params){
		if(isset($params) && count($params) > 0){
			$transaction = new Mradiwallettemplate;
			$transaction->amount = $params['amount'];
			$transaction->order_id = $params['order_id'];
			$transaction->user_id = $params['user_id'];
			$transaction->item_name = $params['item_name'];
			$transaction->campaign_id = $params['campaign_id'];
			$transaction->save();

			//get transaction details to process
			$transactions = Mradiwallettemplate::find($transaction->id);
			
			return $transactions;
		}
	}
	
	public static function getTemplateTransactions(){
		$transactions = DB::select(DB::raw('select mcb.*, drv.* from mradiwallettemplates mcb inner join
							(SELECT account_id, firstname, lastname, phone, email_address
							from accounts_dbx ) drv
							on mcb.user_id = drv.account_id
							where mcb.mradistatustransaction_id = 1'));
		$pageNumber = Input::get('page', 1);
		$perpage = 15;
			
		$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
		$transactions = Paginator::make($slice, count($transactions), $perpage);
		
		return $transactions;
	}
	
	
    
    
}
