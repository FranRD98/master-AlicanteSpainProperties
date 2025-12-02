
ALTER TABLE `properties_properties` CHANGE `updated_prop` `updated_prop` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

REPAIR TABLE properties_properties;
CHECK TABLE properties_properties;
ALTER TABLE properties_properties ENGINE=InnoDB;

REPAIR TABLE properties_types;
CHECK TABLE properties_types;
ALTER TABLE properties_types ENGINE=InnoDB;

REPAIR TABLE properties_loc1;
CHECK TABLE properties_loc1;
ALTER TABLE properties_loc1 ENGINE=InnoDB;

REPAIR TABLE properties_loc2;
CHECK TABLE properties_loc2;
ALTER TABLE properties_loc2 ENGINE=InnoDB;

REPAIR TABLE properties_loc3;
CHECK TABLE properties_loc3;
ALTER TABLE properties_loc3 ENGINE=InnoDB;

REPAIR TABLE properties_loc4;
CHECK TABLE properties_loc4;
ALTER TABLE properties_loc4 ENGINE=InnoDB;

REPAIR TABLE properties_coast;
CHECK TABLE properties_coast;
ALTER TABLE properties_coast ENGINE=InnoDB;

REPAIR TABLE properties_status;
CHECK TABLE properties_status;
ALTER TABLE properties_status ENGINE=InnoDB;

REPAIR TABLE properties_tags;
CHECK TABLE properties_tags;
ALTER TABLE properties_tags ENGINE=InnoDB;

REPAIR TABLE properties_features;
CHECK TABLE properties_features;
ALTER TABLE properties_features ENGINE=InnoDB;

REPAIR TABLE properties_kitchen;
CHECK TABLE properties_kitchen;
ALTER TABLE properties_kitchen ENGINE=InnoDB;

REPAIR TABLE properties_property_tag;
CHECK TABLE properties_property_tag;
ALTER TABLE properties_property_tag ENGINE=InnoDB;

/*--####################################################################################--
--################################# INDEX properties_types###############################--
--####################################################################################--*/
ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_ca (titulo_ca_prop, descripcion_ca_prop, title_ca_prop, keywords_ca_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_da (titulo_da_prop, descripcion_da_prop, title_da_prop, keywords_da_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_de (titulo_de_prop, descripcion_de_prop, title_de_prop, keywords_de_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_en (titulo_en_prop, descripcion_en_prop, title_en_prop, keywords_en_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_es (titulo_es_prop, descripcion_es_prop, title_es_prop, keywords_es_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_fi (titulo_fi_prop, descripcion_fi_prop, title_fi_prop, keywords_fi_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_fr (titulo_fr_prop, descripcion_fr_prop, title_fr_prop, keywords_fr_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_is (titulo_is_prop, descripcion_is_prop, title_is_prop, keywords_is_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_nl (titulo_nl_prop, descripcion_nl_prop, title_nl_prop, keywords_nl_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_no (titulo_no_prop, descripcion_no_prop, title_no_prop, keywords_no_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_pl (titulo_pl_prop, descripcion_pl_prop, title_pl_prop, keywords_pl_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_ru (titulo_ru_prop, descripcion_ru_prop, title_ru_prop, keywords_ru_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_se (titulo_se_prop, descripcion_se_prop, title_se_prop, keywords_se_prop);

ALTER TABLE properties_properties 
ADD FULLTEXT INDEX ft_index_zh (titulo_zh_prop, descripcion_zh_prop, title_zh_prop, keywords_zh_prop);

/*--####################################################################################--
--################################ INDEX  roperties_types###############################--
--####################################################################################--*/

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_ca (types_ca_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_da (types_da_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_de (types_de_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_en (types_en_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_es (types_es_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_fi (types_fi_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_fr (types_fr_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_is (types_is_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_nl (types_nl_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_no (types_no_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_pl (types_pl_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_ru (types_ru_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_se (types_se_typ);

ALTER TABLE properties_types 
ADD FULLTEXT INDEX ft_index_types_zh (types_zh_typ);


/*--####################################################################################--
--###############################  INDEX  properties_loc1##############################--
--####################################################################################--*/

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_ca (name_ca_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_da (name_da_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_de (name_de_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_en (name_en_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_es (name_es_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_fi (name_fi_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_fr (name_fr_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_is (name_is_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_nl (name_nl_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_no (name_no_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_pl (name_pl_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_ru (name_ru_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_se (name_se_loc1);

ALTER TABLE properties_loc1 
ADD FULLTEXT INDEX ft_index_name_zh (name_zh_loc1);


/*--####################################################################################--
--############################  INDEX  properties_loc2 ################################--
--####################################################################################--*/

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_ca (name_ca_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_da (name_da_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_de (name_de_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_en (name_en_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_es (name_es_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_fi (name_fi_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_fr (name_fr_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_is (name_is_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_nl (name_nl_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_no (name_no_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_pl (name_pl_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_ru (name_ru_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_se (name_se_loc2);

ALTER TABLE properties_loc2 
ADD FULLTEXT INDEX ft_index_name_zh (name_zh_loc2);

/*--####################################################################################--
--############################## INDEX properties_loc3##################################--
--####################################################################################--*/

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_ca (name_ca_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_da (name_da_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_de (name_de_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_en (name_en_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_es (name_es_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_fi (name_fi_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_fr (name_fr_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_is (name_is_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_nl (name_nl_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_no (name_no_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_pl (name_pl_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_ru (name_ru_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_se (name_se_loc3);

ALTER TABLE properties_loc3 
ADD FULLTEXT INDEX ft_index_name_zh (name_zh_loc3);

/*--####################################################################################--
--##############################  INDEX properties_loc4 ################################--
--####################################################################################--*/

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_ca (name_ca_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_da (name_da_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_de (name_de_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_en (name_en_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_es (name_es_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_fi (name_fi_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_fr (name_fr_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_is (name_is_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_nl (name_nl_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_no (name_no_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_pl (name_pl_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_ru (name_ru_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_se (name_se_loc4);

ALTER TABLE properties_loc4 
ADD FULLTEXT INDEX ft_index_name_zh (name_zh_loc4);


/*--####################################################################################--
--############################### INDEX properties_coast################################--
--####################################################################################--*/

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_ca (coast_ca_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_da (coast_da_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_de (coast_de_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_en (coast_en_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_es (coast_es_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_fi (coast_fi_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_fr (coast_fr_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_is (coast_is_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_nl (coast_nl_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_no (coast_no_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_pl (coast_pl_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_ru (coast_ru_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_se (coast_se_cst);

ALTER TABLE properties_coast 
ADD FULLTEXT INDEX ft_index_coast_zh (coast_zh_cst);

/*--####################################################################################--
--############################### INDEX properties_status #############################--
--####################################################################################--*/

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_ca (status_ca_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_da (status_da_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_de (status_de_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_en (status_en_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_es (status_es_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_fi (status_fi_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_fr (status_fr_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_is (status_is_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_nl (status_nl_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_no (status_no_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_pl (status_pl_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_ru (status_ru_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_se (status_se_sta);

ALTER TABLE properties_status 
ADD FULLTEXT INDEX ft_index_status_zh (status_zh_sta);

/*--####################################################################################--
--###############################  INDEX  properties_tags###############################--
--####################################################################################--*/

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_ca (tag_ca_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_da (tag_da_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_de (tag_de_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_en (tag_en_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_es (tag_es_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_fi (tag_fi_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_fr (tag_fr_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_is (tag_is_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_nl (tag_nl_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_no (tag_no_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_pl (tag_pl_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_ru (tag_ru_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_se (tag_se_tag);

ALTER TABLE properties_tags 
ADD FULLTEXT INDEX ft_index_tag_zh (tag_zh_tag);


/*--####################################################################################--
--############################## INDEX properties_features #############################--
--####################################################################################--*/

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_ca (feature_ca_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_da (feature_da_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_de (feature_de_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_en (feature_en_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_es (feature_es_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_fi (feature_fi_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_fr (feature_fr_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_is (feature_is_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_nl (feature_nl_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_no (feature_no_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_pl (feature_pl_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_ru (feature_ru_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_se (feature_se_feat);

ALTER TABLE properties_features 
ADD FULLTEXT INDEX ft_index_feature_zh (feature_zh_feat);


/*--####################################################################################--
--############################ INDEX properties_kitchen (tipos) ########################--
--####################################################################################--*/

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_ca (kitchen_ca_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_da (kitchen_da_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_de (kitchen_de_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_en (kitchen_en_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_es (kitchen_es_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_fi (kitchen_fi_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_fr (kitchen_fr_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_is (kitchen_is_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_nl (kitchen_nl_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_no (kitchen_no_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_pl (kitchen_pl_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_ru (kitchen_ru_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_se (kitchen_se_kchn);

ALTER TABLE properties_kitchen 
ADD FULLTEXT INDEX ft_index_kitchen_zh (kitchen_zh_kchn);


/*--RELACIONES*/ 
ALTER TABLE `properties_properties` ADD CONSTRAINT `localidad` FOREIGN KEY (`localidad_prop`) REFERENCES `properties_loc4`(`id_loc4`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `properties_properties` ADD CONSTRAINT `tipo` FOREIGN KEY (`tipo_prop`) REFERENCES `properties_types`(`id_typ`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `properties_properties` ADD FOREIGN KEY (`operacion_prop`) REFERENCES `properties_status`(`id_sta`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `properties_types` ADD CONSTRAINT `typeParent` FOREIGN KEY (`parent_typ`) REFERENCES `properties_types`(`id_typ`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `properties_loc4` ADD FOREIGN KEY (`loc3_loc4`) REFERENCES `properties_loc3`(`id_loc3`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `properties_loc3` ADD FOREIGN KEY (`loc2_loc3`) REFERENCES `properties_loc2`(`id_loc2`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `properties_loc2` ADD FOREIGN KEY (`loc1_loc2`) REFERENCES `properties_loc1`(`id_loc1`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `properties_property_tag` ADD FOREIGN KEY (`property`) REFERENCES `properties_properties`(`id_prop`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/*--en caso de que de error al ejecutar esa relacion, ejecutar este delete:
--DELETE FROM properties_property_tag WHERE property NOT IN (SELECT id_prop FROM properties_properties);
--elimina todas las relaciones con id de propiedades inexistentes.*/

