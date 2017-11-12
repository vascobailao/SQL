-- Script.sql

-- 3.1
SELECT * from concorrente C where not exists (SELECT * from lance L where C.pessoa=L.pessoa);

-- 3.2
SELECT C.pessoa , A.nome from concorrente C, pessoa A where C.pessoa=A.nif and  exists (select * from pessoac P where C.pessoa=P.nif) group by C.pessoa having count(C.pessoa)=2 ;

-- 3.3
Select A.leilao,  max(A.valor/L.valorbase) from lance A, leilao L where exists (Select *from leilaor R where A.leilao=R.lid and L.dia=R.dia and L.nrleilaonodia=R.nrleilaonodia) and A.valor/L.valorbase >=ALL (Select B.valor/P.valorbase from lance B, leilao P where exists (select *from leilaor U where B.leilao=U.lid and P.dia=U.dia and P.nrleilaonodia=U.nrleilaonodia) and A.leilao != B.leilao and A.valor!=B.valor);

-- 3.4
select pc1.nif, pc1.capitalsocial from pessoac as pc1, pessoac as pc2 where pc1.nif!=pc2.nif and pc1.capitalsocial=pc2.capitalsocial group by pc1.nif order by pc1.capitalsocial;