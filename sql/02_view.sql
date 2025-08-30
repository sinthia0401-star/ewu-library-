CREATE OR REPLACE VIEW vw_book_with_authors AS
SELECT
  b.book_id,
  b.title,
  b.isbn,
  b.publisher,
  b.publish_year,
  b.category_id,
  b.total_copies,
  b.available_copies,
  LISTAGG(a.name, ', ') WITHIN GROUP (ORDER BY a.name) AS authors
FROM book b
LEFT JOIN book_author ba ON ba.book_id = b.book_id
LEFT JOIN author a ON a.author_id = ba.author_id
GROUP BY
  b.book_id, b.title, b.isbn, b.publisher, b.publish_year,
  b.category_id, b.total_copies, b.available_copies;
