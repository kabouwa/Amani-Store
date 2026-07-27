



-- Meilleurs produits

SELECT p.title, sum(oi.quantity) as sales_times
FROM Products P
INNER JOIN order_items oi ON p.id = oi.product_id
GROUP BY oi.product_id
ORDER BY sales_times DESC
LIMIT 5
;