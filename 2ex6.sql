Set profiling=1;

SELECT pc1.nif, pc1.capitalsocial from pessoac as pc1, pessoac as pc2 where pc1.nif!=pc2.nif and pc1.capitalsocial=pc2.capitalsocial group by pc1.nif order by pc1.capitalsocial;

EXPLAIN SELECT pc1.nif, pc1.capitalsocial from pessoac as pc1, pessoac as pc2 where pc1.nif!=pc2.nif and pc1.capitalsocial=pc2.capitalsocial group by pc1.nif order by pc1.capitalsocial;

CREATE	INDEX	capitalsocial_idx	ON	pessoac	(capitalsocial);

SELECT "tabela com index";

SELECT pc1.nif, pc1.capitalsocial from pessoac as pc1, pessoac as pc2 where pc1.nif!=pc2.nif and pc1.capitalsocial=pc2.capitalsocial group by pc1.nif order by pc1.capitalsocial;

EXPLAIN SELECT pc1.nif, pc1.capitalsocial from pessoac as pc1, pessoac as pc2 where pc1.nif!=pc2.nif and pc1.capitalsocial=pc2.capitalsocial group by pc1.nif order by pc1.capitalsocial;

SHOW profiles;

SET profiling = 0;

ALTER TABLE pessoac DROP INDEX capitalsocial_idx;




