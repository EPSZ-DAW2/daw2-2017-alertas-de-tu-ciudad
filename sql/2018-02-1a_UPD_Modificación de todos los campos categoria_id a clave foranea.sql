USE `daw2_alertas`;
ALTER TABLE `categorias` ADD INDEX(`categoria_id`);
ALTER TABLE `categorias` ADD CONSTRAINT `categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `daw2_alertas`.`categorias`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `categorias_etiquetas` ADD INDEX(`categoria_id`);
ALTER TABLE `categorias_etiquetas` ADD INDEX(`etiqueta_id`);
ALTER TABLE `categorias_etiquetas` ADD CONSTRAINT `etiqueta_id` FOREIGN KEY (`etiqueta_id`) REFERENCES `daw2_alertas`.`etiquetas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `categorias_etiquetas` ADD CONSTRAINT `categorias_id` FOREIGN KEY (`categoria_id`) REFERENCES `daw2_alertas`.`categorias`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `alertas` ADD INDEX(`categoria_id`);
ALTER TABLE `alertas` ADD CONSTRAINT `cat_id` FOREIGN KEY (`categoria_id`) REFERENCES `daw2_alertas`.`categorias`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
