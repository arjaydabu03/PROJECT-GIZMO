<?php
namespace App\Responses;

class Status
{
    //STATUS CODES
    const CREATED_STATUS = 201;
    const UNPROCESS_STATUS = 422;
    const DATA_NOT_FOUND = 404;
    const SUCESS_STATUS = 200;
    const DENIED_STATUS = 403;
    const CUT_OFF_STATUS = 409;

    //CRUD OPERATION
    const USER_SAVE = "User successfully registered.";
    const STORE_REGISTERED = "Store successfully registered.";
    const CATEGORY_SAVE = "Category successfully registered.";
    const MATERIAL_SAVE = "Material successfully registered.";
    const MATERIAL_IMPORT = "Material imported successfully.";

    const COMPANY_SAVE = "Company save successfully.";
    const DEPARTMENT_SAVE = "Department save successfully.";
    const LOCATION_SAVE = "Location save successfully.";
    const ORDER_SAVE = "Order successfully saved.";
    const UOM_SAVE = "Unit of measurement successfully saved.";
    const WAREHOUSE_SAVE = "Warehouse successfully saved.";
    const ROLE_SAVE = "Role successfully saved.";
    const CUTOFF_SAVE = "Cut off successfully saved.";
    const HRI_SAVE = "Hri customer successfully saved.";
    const TYPE_SAVE = "Type successfully saved.";
    // DISPLAY DATA
    const USER_DISPLAY = "User display successfully.";
    const TYPE_DISPLAY = "Type display successfully.";
    const HRI_DISPLAY = "HRI display successfully.";
    const STORE_DISPLAY = "Store display successfully.";
    const CATEGORY_DISPLAY = "Category display successfully.";
    const MATERIAL_DISPLAY = "Material display successfully.";
    const ORDER_DISPLAY = "Order display successfully.";
    const COUNT_DISPLAY = "Order count display successfully.";
    const UOM_DISPLAY = "Unit of measurement display successfully.";
    const WAREHOUSE_DISPLAY = "Warehouse display successfully.";
    const ROLE_DISPLAY = "Role display successfully.";
    const CUT_OFF_DISPLAY = "Cut off display successfully.";
    const COMPANY_DISPLAY = "Company display successfully.";
    const DEPARTMENT_DISPLAY = "Department display successfully.";
    const LOCATION_DISPLAY = "Location display successfully.";
    //UPDATE
    const USER_UPDATE = "User successfully updated.";
    const CATEGORY_UPDATE = "Category successfully updated.";
    const MATERIAL_UPDATE = "Material successfully updated.";
    const ORDER_UPDATE = "Order successfully updated.";
    const UOM_UPDATE = "Unit of measurement successfully updated.";
    const WAREHOUSE_UPDATE = "Warehouse successfully updated.";
    const ROLE_UPDATE = "Role successfully updated.";
    const TRANSACTION_UPDATE = "Transaction successfully updated.";
    const TRANSACTION_POSTED = "Transaction successfully posted.";
    const TRANSACTION_RETURN = "Transaction successfully return.";
    const TRANSACTION_SERVE = "Transaction successfully serve.";
    const HRI_UPDATE = "Hri customer successfully updated.";
    const TYPE_UPDATE = "Type successfully updated.";
    const COMPANY_UPDATE = "Company updated successfully.";
    const DEPARTMENT_UPDATE = "Department updated successfully.";
    const LOCATION_UPDATE = "Location updated successfully.";
    //SOFT DELETE
    const ARCHIVE_STATUS = "Successfully archived.";
    const RESTORE_STATUS = "Successfully restored.";
    //ACCOUNT RESPONSE
    const INVALID_RESPONSE = "The provided credentials are incorrect.";
    const CHANGE_PASSWORD = "Password successfully changed.";
    const LOGIN_USER = "Log-in successfully.";
    const LOGOUT_USER = "Log-out successfully.";

    // DISPLAY ERRORS
    const NOT_FOUND = "Data not found.";
    //VALIDATION
    const SINGLE_VALIDATION = "Data has been validated.";
    const INVALID_ACTION = "Invalid action.";
    const INVALID_UPDATE_POSTED = "Unable to update this transaction is already posted.";
    const NEW_PASSWORD = "Please change your password.";
    const EXISTS = "Data already exists.";
    const ACCESS_DENIED = "You do not have permission.";
    const CUT_OFF = "Cut off reach.";
    const RUSH = "Rush field is required.";
    const DATA_EXPORT = "Data has been exported successfully.";

    const MISSING_HASHTAG = "Missing hashtag.";
}
