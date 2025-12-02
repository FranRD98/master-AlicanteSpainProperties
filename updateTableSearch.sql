ALTER TABLE news ENGINE=InnoDB;

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_ca (
    title_ca_nws, content_ca_nws, tags_ca_nws
);
ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_en (
    title_en_nws,content_en_nws, tags_en_nws
);
ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_es (
    title_es_nws,content_es_nws, tags_es_nws
);
ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_da (
    title_da_nws,content_da_nws, tags_da_nws
);
ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_de ( 
    title_de_nws, content_de_nws, tags_de_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_fi ( 
    title_fi_nws, content_fi_nws, tags_fi_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_fr ( 
    title_fr_nws, content_fr_nws, tags_fr_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_is ( 
    title_is_nws, content_is_nws, tags_is_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_nl ( 
    title_nl_nws, content_nl_nws, tags_nl_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_no ( 
    title_no_nws, content_no_nws, tags_no_nws
);	

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_ru ( 
    title_ru_nws, content_ru_nws, tags_ru_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_se ( 
    title_se_nws, content_se_nws, tags_se_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_zh ( 
    title_zh_nws, content_zh_nws, tags_zh_nws
);

ALTER TABLE news 
ADD FULLTEXT INDEX ft_index_pl ( 
    title_pl_nws, content_pl_nws, tags_pl_nws
);