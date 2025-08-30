CREATE OR REPLACE PROCEDURE borrow_book(p_member_id IN NUMBER, p_book_id IN NUMBER) AS
  v_avail NUMBER;
BEGIN
  SELECT available_copies INTO v_avail
  FROM book
  WHERE book_id = p_book_id
  FOR UPDATE;

  IF v_avail <= 0 THEN
    RAISE_APPLICATION_ERROR(-20001, 'No copies available');
  END IF;

  INSERT INTO borrow_txn(member_id, book_id, borrowed_on, due_on)
  VALUES (p_member_id, p_book_id, SYSDATE, SYSDATE + 14);

  UPDATE book
  SET available_copies = available_copies - 1
  WHERE book_id = p_book_id;

  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE return_book(p_txn_id IN NUMBER) AS
  v_book_id   NUMBER;
  v_returned  DATE;
BEGIN
  SELECT book_id, returned_on
  INTO v_book_id, v_returned
  FROM borrow_txn
  WHERE txn_id = p_txn_id
  FOR UPDATE;

  IF v_returned IS NOT NULL THEN
    RAISE_APPLICATION_ERROR(-20002, 'Already returned');
  END IF;

  UPDATE borrow_txn
  SET returned_on = SYSDATE
  WHERE txn_id = p_txn_id;

  UPDATE book
  SET available_copies = available_copies + 1
  WHERE book_id = v_book_id;

  COMMIT;
END;
/
