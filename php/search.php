<?php
require_once '../php/config.php';
require_once '../php/db.php';
$db = connect(DB_SERVER, USER, PASSWORD, DB_NAME);
if (!empty($_POST)) {
    $mydata = '';

    $text = $_POST['search_text'];
    if (!empty($text)) {
        $sql
            = "SELECT * FROM student_data WHERE  fname LIKE '%" . $text . "%' ";
        $searchResult = mysqli_query($db, $sql);
        $mydata .= "<div class=\"table-responsive\">";
        $mydata .= "<table class=\"table align-items-center table-dark table-flush\" id=\"datatable\">";
        $mydata .= "<thead class=\"thead-dark\">";
        $mydata .= "<tr>";
        $mydata .=    "<th scope=\"col\" class=\"sort\" data-sort=\"name\">Name</th>";
        $mydata .=    "<th scope=\"col\" class=\"sort\" data-sort=\"budget\">Admission Number</th>";
        $mydata .=    "<th scope=\"col\">School</th>";
        $mydata .=   "<th scope=\"col\" class=\"sort\" data-sort=\"status\">Status</th>";
        $mydata .=    "<th scope=\"col\" class=\"sort\" data-sort=\"completion\">Completion</th>";
        $mydata .=    "<th scope=\"col\"></th>";
        $mydata .= "</tr>";
        $mydata .= "</thead>";
        $mydata .=  "<tbody class=\"list\" id=\"tabledata\">";
        $num = 1;
        while ($row = $searchResult->fetch_assoc()) {
            $complete = $row['completion'];
            if ($complete < 100) {
                $background = "bg-warning";
                $status = "pending";
            } else {
                $background = "bg-success";
                $status = "complete";
            }
            $mydata .=  "<tr>";
            $mydata .=   "<th scope=\"row\">";
            $mydata .=     "<div class=\"media align-items-center\">";
            $mydata .=        "<a href=\"#\" class=\"avatar rounded-circle mr-3\">";
            $mydata .=           "<img  src=\"" . $row['profile_picture'] .  " \" height=\"40\" width=\"100\" alt=\"Profile photo\">";
            $mydata .=          "</a>";
            $mydata .=        "<div class=\"media-body\">";
            $mydata .=            "<span class=\"name mb-0 text-sm\">" . $row['fname'] . " " . $row['lname'] . "</span>";
            $mydata .=       "</div>";
            $mydata .=      "</div>";
            $mydata .=     "</th>";
            $mydata .=     "<td>";
            $mydata .=        $row['adm_number'];
            $mydata .=    "</td>";
            $mydata .=   "<td>";
            $mydata .=         "Computing and Informatics"; //TODO $val['school'];
            $mydata .=     "</td>";
            $mydata .=   "<td>";
            $mydata .=       "<span class=\"badge badge-dot mr-4\">";
            $mydata .=           "<i class=\"" . $background . "\"></i>";
            $mydata .=         "<span class=\"status\">" . $status . "</span>";
            $mydata .=         "</span>";
            $mydata .=     "</td>";
            $mydata .=     "<td>";
            $mydata .=         "<div class=\"d-flex align-items-center\">";
            $mydata .=             "<span class=\"completion mr-2\">" . $complete . "%</span>";
            $mydata .=         "</div>";
            $mydata .=        "<div>";
            $mydata .=                "<div class=\"progress\">";
            $mydata .=                     "<div class=\"progress-bar " . $background . "\" role=\"progressbar\" aria-valuenow=\"" . $complete . "\"  aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " . $complete . "%;\"></div>";
            $mydata .=                  "</div>"; //aria-valuenow=\"."$val['completion'];."\"                    //width: ".$val['completion']."%"."
            $mydata .=         "</div>";
            $mydata .=     "</td>";
            $mydata .=     "<td class=\"text-right\">";
            $mydata .=        "<div class=\"dropdown\">";
            $mydata .=            "<a class=\"btn btn-sm btn-icon-only text-light\" href=\"#\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
            $mydata .=            "<i class=\"fas fa-ellipsis-v\"></i>";
            $mydata .=            "</a>";
            $mydata .=             "<div class=\"dropdown-menu dropdown-menu-right dropdown-menu-arrow\">";
            $mydata .=                 "<a class=\"dropdown-item\" href=\"#" . $row['fname'] . $num . "\" data-toggle=\"modal\">Edit</a>";
            $mydata .=                 "<a class=\"dropdown-item\" href=\"#deleteRecord" . $row['ID'] . "\" data-toggle=\"modal\">Delete</a>";
            $mydata .=             "</div>";
            $mydata .=        "</div>";
            $mydata .=     "</td>";
            $mydata .=    "</tr>";
            $mydata .=  "<div class=\"modal fade\" id=\"" . $row['fname'] . $num . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"" . $row['lname'] . " aria-hidden=\"true\">";
            $mydata .=      "<div class=\"modal-dialog modal-lg\" role=\"document\">";
            $mydata .=       "<div class=\"modal-content\">";
            $mydata .=          "<div class=\"modal-header text-center\">";
            $mydata .=            "<h5 class=\"modal-title\" id=\"" . $row['lname'] . "\">Edit</h5>";
            $mydata .= "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
            $mydata .=           "<span aria-hidden=\"true\">&times;</span>";
            $mydata .=     "</button>";
            $mydata .= "</div>";
            $mydata .= "<div class=\"modal-body\">";
            $mydata .= "<form action=\"../php/adminUpdateRecord.php\" method=\"POST\">";
            $mydata .=   "<input type=\"hidden\" name=\"id\" value=\"" . $row['ID'] . "\" >";
            $mydata .=  "<h6 class=\"heading-small text-muted mb-4\">User information</h6>";
            $mydata .=     "<div class=\"pl-lg-4\">";
            $mydata .=  "<div class=\"row\">";
            $mydata .=   "<div class=\"col-lg-6\">";
            $mydata .=     "<div class=\"form-group\">";
            $mydata .=   "<label class=\"form-control-label text-light\" for=\"input-first-name\">First name</label>";
            $mydata .= "<input type=\"text\" id=\"input-first-name\" class=\"form-control text-dark\" name=\"fname\" value=\"" . $row['fname'] . "\" >";
            $mydata .=  "</div>";
            $mydata .=  "</div>";
            $mydata .= "<div class=\"col-lg-6\">";
            $mydata .=          "<div class=\"form-group\">";
            $mydata .=   "<label class=\"form-control-label text-light\" for=\"input-last-name\">Last name</label>";
            $mydata .= "<input type=\"text\" id=\"input-last-name\" class=\"form-control text-dark\" name=\"lname\" value=\"" . $row['lname'] . "\">";
            $mydata .=   "</div>";
            $mydata .= "</div>";
            $mydata .= "</div>";
            $mydata .= "<div class=\"row\">";
            $mydata .= "<div class=\"col-lg-6\">";
            $mydata .= "<div class=\"form-group\">";
            $mydata .=   "<label class=\"form-control-label text-light\" for=\"input-username\">Username</label>";
            $mydata .=  "<input type=\"text\" id=\"input-username\" class=\"form-control text-dark\" name=\"admNumber\" placeholder=\"Username\" value=\"" . $row['adm_number'] . "\">";
            $mydata .= "</div>";
            $mydata .=       "</div>";
            $mydata .= "<div class=\"col-lg-6\">";
            $mydata .=  "<div class=\"form-group\">";
            $mydata .=    "<label class=\"form-control-label text-light\" for=\"input-password\">Password</label>";
            $mydata .=       "<input type=\"text\" id=\"input-password\" class=\"form-control text-dark\" placeholder=\"Password\" name=\"pass\" value=\"" . $row['pass'] . "\" >";
            $mydata .=      "</div>";
            $mydata .=     "</div>";
            $mydata .=   "</div>";
            $mydata .= "</div>";
            $mydata .= "<hr class=\"my-4\" />";
            $mydata .= "<h6 class=\"heading-small text-muted mb-4\">Contact information</h6>";
            $mydata .= "<div class=\"pl-lg-4\">";
            $mydata .=    "<div class=\"row\">";
            $mydata .=      "<div class=\"col-lg-6\">";
            $mydata .=    "<div class=\"form-group\">";
            $mydata .=      "<label class=\"form-control-label text-light\" for=\"input-email\">Email address</label>";
            $mydata .=       "<input type=\"email\" id=\"input-email\" class=\"form-control text-dark\" placeholder=\"Email\">";
            $mydata .=     "</div>";
            $mydata .=    "</div>";
            $mydata .= "<div class=\"col-lg-6\">";
            $mydata .=   "<div class=\"form-group\">";
            $mydata .=          "<label class=\"form-control-label text-light\" for=\"input-country\">Phone Number</label>";
            $mydata .=            "<input type=\"number\" id=\"input-postal-code\" class=\"form-control text-dark\" placeholder=\"phone number\">";
            $mydata .=          "</div>";
            $mydata .=         "</div>";
            $mydata .=      "</div>";
            $mydata .=      "<div class=\"modal-footer\">";
            $mydata .=        "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
            $mydata .=        "<button type=\"submit\" class=\"btn btn-primary\">Save changes</button>";
            $mydata .=      "</div>";
            $mydata .= "</form>";
            $mydata .= "</div>";
            $mydata .= " </div>";
            $mydata .= "</div>";
            $mydata .= "</div>";

            // $mydata[] = $row;
            $num++;
        }
        $mydata .= "</tbody>";
        $mydata .= "</table>";
        echo json_encode($mydata);
    }
}
