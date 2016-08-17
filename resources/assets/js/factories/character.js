angular
	.module('inspinia')	
	.factory('charactersFactory', function(){
		return {
			calculate : function(number, text){
				if(!text || !text.length) return 0;
				var length = text.length;
				if(number.match(/^50001/)){
					if(text.match(/^[ا-ی]/)){
						return this.gamaPersian(length);
					}
					return this.gamaLatin(length);
				} else {
					if(text.match(/^[ا-ی]/)){
						return this.otherPersian(length);
					}
					return this.otherLatin(length);
				}
			},

			gamaPersian : function(length){
				if(length <= 70) return 1;
				if(length <= 132) return 2;
				if(length <= 198) return 3;
				if(length <= 264) return 4;
				if(length <= 330) return 5;
				if(length <= 396) return 6;
				if(length <= 462) return 7;
				if(length <= 528) return 8;
				if(length <= 594) return 9;
				if(length <= 660) return 10;
				return false;
			},

			gamaLatin : function(length){
				if(length <= 140) return 1;
				if(length <= 264) return 2;
				if(length <= 396) return 3;
				if(length <= 528) return 4;
				if(length <= 660) return 5;
				if(length <= 792) return 6;
				if(length <= 924) return 7;
				if(length <= 1056) return 8;
				if(length <= 1188) return 9;
				if(length <= 1320) return 10;
				return false;
			},

			otherPersian : function(length){
				if(length <= 70) return 1;
				if(length <= 134) return 2;
				if(length <= 201) return 3;
				if(length <= 268) return 4;
				if(length <= 335) return 5;
				if(length <= 402) return 6;
				if(length <= 469) return 7;
				if(length <= 536) return 8;
				if(length <= 603) return 9;
				if(length <= 670) return 10;
				return false;
			},

			otherLatin : function(length){
				if(length <= 160) return 1;
				if(length <= 306) return 2;
				if(length <= 459) return 3;
				if(length <= 612) return 4;
				if(length <= 765) return 5;
				if(length <= 918) return 6;
				if(length <= 1071) return 7;
				if(length <= 1224) return 8;
				if(length <= 1377) return 9;
				if(length <= 1530) return 10;
				return false;
			}
		}
	});