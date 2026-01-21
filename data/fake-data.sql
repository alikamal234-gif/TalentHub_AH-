-- ROLES
INSERT INTO roles (name, created_at, deleted_at)
VALUES ('Admin', '2025-01-01', NULL),
       ('Recruiter', '2025-01-02', NULL),
       ('Candidate', '2025-01-03', NULL);

-- USERS
INSERT INTO users (role_id, name, speciality, email, password, phone, image, created_at, deleted_at)
VALUES (1, 'Alice Admin', NULL, 'alice.admin@example.com', 'hashed_pass_1', '111-222-333', NULL, '2025-01-05', NULL),
       (2, 'Bob Recruiter', 'HR Manager', 'bob.recruiter@example.com', 'hashed_pass_2', '222-333-444', NULL,
        '2025-01-06', NULL),
       (2, 'Sarah Recruiter', 'Tech Recruiter', 'sarah.recruiter@example.com', 'hashed_pass_3', '333-444-555', NULL,
        '2025-01-06', NULL),
       (3, 'John Candidate', 'Backend Developer', 'john.candidate@example.com', 'hashed_pass_4', '444-555-666', NULL,
        '2025-01-07', NULL),
       (3, 'Emma Candidate', 'UI/UX Designer', 'emma.candidate@example.com', 'hashed_pass_5', '555-666-777', NULL,
        '2025-01-07', NULL),
       (3, 'Mark Candidate', 'Data Analyst', 'mark.candidate@example.com', 'hashed_pass_6', '666-777-888', NULL,
        '2025-01-07', NULL);

-- CATEGORIES
INSERT INTO categories (name, created_at, deleted_at)
VALUES ('Software Development', '2025-01-10', NULL),
       ('Design', '2025-01-10', NULL),
       ('Data Science', '2025-01-10', NULL),
       ('Marketing', '2025-01-10', NULL);

-- OFFERS
INSERT INTO offers (category_id, owner_id, name, description, salary, city, contact, company, created_at, deleted_at)
VALUES (1, 2, 'Backend Developer', 'Looking for a PHP/Laravel backend developer', 4500, 'New York', 'hr@techcorp.com',
        'TechCorp', '2025-01-12', NULL),
       (2, 2, 'UI/UX Designer', 'Creative designer for mobile and web apps', 3800, 'Los Angeles', 'jobs@designify.com',
        'Designify', '2025-01-12', NULL),
       (3, 3, 'Data Analyst', 'Analyze company data and build reports', 4200, 'Chicago', 'careers@datainsight.com',
        'DataInsight', '2025-01-13', NULL),
       (1, 3, 'Frontend Developer', 'React developer needed', 4000, 'Remote', 'jobs@webstars.com', 'WebStars',
        '2025-01-13', NULL);

-- TAGS
INSERT INTO tags (name, created_at, deleted_at)
VALUES ('PHP', '2025-01-15', NULL),
       ('Laravel', '2025-01-15', NULL),
       ('React', '2025-01-15', NULL),
       ('UI/UX', '2025-01-15', NULL),
       ('Figma', '2025-01-15', NULL),
       ('Python', '2025-01-15', NULL),
       ('SQL', '2025-01-15', NULL),
       ('Marketing', '2025-01-15', NULL);

-- CANDIDATURES
INSERT INTO candidatures (user_id, offer_id, message, cv, status, created_at)
VALUES (4, 1, 'I am very interested in this backend position.', NULL, 'pending', '2025-01-20'),
       (5, 2, 'I have strong experience in UI/UX and Figma.', NULL, 'accepted', '2025-01-20'),
       (6, 3, 'Data analysis and reporting are my strengths.', NULL, 'rejected', '2025-01-21'),
       (4, 4, 'Frontend with React is my main skill.', NULL, 'pending', '2025-01-21');

-- OFFER_TAG (many-to-many between offers and tags)
INSERT INTO offer_tag (offer_id, tag_id)
VALUES (1, 1), -- Backend Developer -> PHP
       (1, 2), -- Backend Developer -> Laravel
       (2, 4), -- UI/UX Designer -> UI/UX
       (2, 5), -- UI/UX Designer -> Figma
       (3, 6), -- Data Analyst -> Python
       (3, 7), -- Data Analyst -> SQL
       (4, 3);
-- Frontend Developer -> React

-- USER_TAG (many-to-many between users and tags)
INSERT INTO user_tag (user_id, tag_id)
VALUES (4, 1), -- John -> PHP
       (4, 2), -- John -> Laravel
       (4, 3), -- John -> React
       (5, 4), -- Emma -> UI/UX
       (5, 5), -- Emma -> Figma
       (6, 6), -- Mark -> Python
       (6, 7); -- Mark -> SQL
