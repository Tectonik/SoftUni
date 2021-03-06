namespace Git.Data.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using Git.Common;

    public class Repository
    {
        public Repository()
        {
            this.Id = Helpers.NewId;
            this.Commits = new List<Commit>();
        }

        public string Id { get; set; }

        [Required]
        [MinLength(3)]
        [MaxLength(10)]
        public string Name { get; set; }

        public DateTime CreatedOn { get; set; }

        public bool IsPublic { get; set; }

        public string OwnerId { get; set; }

        public User Owner { get; set; }

        public virtual ICollection<Commit> Commits { get; set; }
    }
}