set profiling=1;

Select A.leilao,  max(A.valor/L.valorbase) from lance A, leilao L where exists (Select *from leilaor R where A.leilao=R.lid and L.dia=R.dia and L.nrleilaonodia=R.nrleilaonodia) and A.valor/L.valorbase >=ALL (Select B.valor/P.valorbase from lance B, leilao P where exists (select *from leilaor U where B.leilao=U.lid and P.dia=U.dia and P.nrleilaonodia=U.nrleilaonodia) and A.leilao != B.leilao and A.valor!=B.valor);


EXPLAIN Select A.leilao,  max(A.valor/L.valorbase) from lance A, leilao L where exists (Select *from leilaor R where A.leilao=R.lid and L.dia=R.dia and L.nrleilaonodia=R.nrleilaonodia) and A.valor/L.valorbase >=ALL (Select B.valor/P.valorbase from lance B, leilao P where exists (select *from leilaor U where B.leilao=U.lid and P.dia=U.dia and P.nrleilaonodia=U.nrleilaonodia) and A.leilao != B.leilao and A.valor!=B.valor);


CREATE INDEX	valor_idx	ON	 lance (valor);


SELECT "tabela com index"; 

Select A.leilao,  max(A.valor/L.valorbase) from lance A, leilao L where exists (Select *from leilaor R where A.leilao=R.lid and L.dia=R.dia and L.nrleilaonodia=R.nrleilaonodia) and A.valor/L.valorbase >=ALL (Select B.valor/P.valorbase from lance B, leilao P where exists (select *from leilaor U where B.leilao=U.lid and P.dia=U.dia and P.nrleilaonodia=U.nrleilaonodia) and A.leilao != B.leilao and A.valor!=B.valor);

EXPLAIN Select A.leilao,  max(A.valor/L.valorbase) from lance A, leilao L where exists (Select *from leilaor R where A.leilao=R.lid and L.dia=R.dia and L.nrleilaonodia=R.nrleilaonodia) and A.valor/L.valorbase >=ALL (Select B.valor/P.valorbase from lance B, leilao P where exists (select *from leilaor U where B.leilao=U.lid and P.dia=U.dia and P.nrleilaonodia=U.nrleilaonodia) and A.leilao != B.leilao and A.valor!=B.valor);

SHOW profiles;

set profiling=0;


ALTER TABLE lance  DROP INDEX valor_idx;
