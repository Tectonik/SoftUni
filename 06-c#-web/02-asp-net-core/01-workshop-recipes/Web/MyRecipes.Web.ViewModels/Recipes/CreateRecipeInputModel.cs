namespace MyRecipes.Web.ViewModels.Recipes
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;

    using Microsoft.AspNetCore.Http;

    public class CreateRecipeInputModel
    {
        // public CreateRecipeInputModel()
        // {
        //     this.Images = new HashSet<IFormFile>();
        //     this.Ingredients = new HashSet<RecipeIngredientInputModel>();
        //     this.CategoriesItems = new HashSet<KeyValuePair<string, string>>();
        // }

        [Required]
        [MinLength(4)]
        public string Name { get; set; }

        [Required]
        [MinLength(100)]
        public string Instructions { get; set; }

        [Range(0, 24 * 60)]
        [Display(Name = "Preparation time (in minutes)")]
        public int PreparationTime { get; set; }

        [Range(0, 24 * 60)]
        [Display(Name = "Cooking time (in minutes)")]
        public int CookingTime { get; set; }

        [Range(1, 100)]
        [Display(Name = "Portions count")]
        public int PortionsCount { get; set; }

        [Display(Name = "Category")]
        public int CategoryId { get; set; }

        [Range(1, 10)]
        public IEnumerable<IFormFile> Images { get; set; }

        [Required]
        public IEnumerable<RecipeIngredientInputModel> Ingredients { get; set; }

        public IEnumerable<KeyValuePair<string, string>> CategoriesItems { get; set; }
    }
}
