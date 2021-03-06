namespace Git.Data.Models
{
    using System;
    using System.ComponentModel.DataAnnotations;
    using Git.Common;

    public class Commit
    {
        public Commit()
        {
            this.Id = Helpers.NewId;
        }

        public string Id { get; set; }

        [Required]
        [MinLength(5)]
        public string Description { get; set; }

        [Required]
        public DateTime CreatedOn { get; set; }

        public string CreatorId { get; set; }

        public User Creator { get; set; }

        public string RepositoryId { get; set; }

        public Repository Repository { get; set; }
    }
}