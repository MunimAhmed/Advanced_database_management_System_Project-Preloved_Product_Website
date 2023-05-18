
--Function to find results from table using by id

CREATE OR REPLACE FUNCTION get_row_by_id(p_table_name IN VARCHAR2, p_id IN NUMBER)
RETURN SYS_REFCURSOR
IS
    l_cursor SYS_REFCURSOR;
BEGIN
    OPEN l_cursor FOR 'SELECT * FROM ' || p_table_name || ' WHERE id = :id' USING p_id;
    RETURN l_cursor;
END;
/

--Function to check the pending payments and completed payments
CREATE OR REPLACE FUNCTION get_orders_by_payment_status(p_payment_status IN VARCHAR2)
RETURN SYS_REFCURSOR
IS
  v_cursor SYS_REFCURSOR;
BEGIN
  OPEN v_cursor FOR
    SELECT * FROM orders WHERE payment_status = p_payment_status;
  RETURN v_cursor;
END;
/




