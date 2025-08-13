--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: blogs; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.blogs (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    heading character varying(255) NOT NULL,
    detail text NOT NULL,
    meta_keywords text,
    meta_description text,
    domain character varying(255) DEFAULT 'advice.pk'::character varying NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.blogs OWNER TO realestateai;

--
-- Name: blogs_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.blogs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.blogs_id_seq OWNER TO realestateai;

--
-- Name: blogs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.blogs_id_seq OWNED BY public.blogs.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO realestateai;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO realestateai;

--
-- Name: cities; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.cities (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'enabled'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT cities_status_check CHECK (((status)::text = ANY ((ARRAY['enabled'::character varying, 'disabled'::character varying])::text[])))
);


ALTER TABLE public.cities OWNER TO realestateai;

--
-- Name: cities_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.cities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cities_id_seq OWNER TO realestateai;

--
-- Name: cities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.cities_id_seq OWNED BY public.cities.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO realestateai;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO realestateai;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO realestateai;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO realestateai;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO realestateai;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: media; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.media (
    id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL,
    uuid uuid,
    collection_name character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    mime_type character varying(255),
    disk character varying(255) NOT NULL,
    conversions_disk character varying(255),
    size bigint NOT NULL,
    manipulations json NOT NULL,
    custom_properties json NOT NULL,
    generated_conversions json NOT NULL,
    responsive_images json NOT NULL,
    order_column integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.media OWNER TO realestateai;

--
-- Name: media_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.media_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.media_id_seq OWNER TO realestateai;

--
-- Name: media_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.media_id_seq OWNED BY public.media.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO realestateai;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO realestateai;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO realestateai;

--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO realestateai;

--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO realestateai;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO realestateai;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO realestateai;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO realestateai;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO realestateai;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: projects; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.projects (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    domain character varying(255) DEFAULT 'advice.pk'::character varying NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    heading character varying(255),
    meta_keywords text,
    meta_description text,
    description text,
    longitude character varying(255),
    latitude character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.projects OWNER TO realestateai;

--
-- Name: projects_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.projects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.projects_id_seq OWNER TO realestateai;

--
-- Name: projects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.projects_id_seq OWNED BY public.projects.id;


--
-- Name: properties; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.properties (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    society_id bigint NOT NULL,
    sub_sector_id bigint,
    purpose character varying(255) NOT NULL,
    property_type character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    keywords text,
    plot_no character varying(255),
    street character varying(255),
    location text,
    latitude numeric(12,8),
    longitude numeric(12,8),
    plot_size character varying(255),
    plot_dimensions character varying(255),
    price integer,
    rent integer,
    rent_type character varying(255) DEFAULT 'monthly'::character varying,
    features json,
    nearby_facilities json,
    installment_plan json,
    best_selling boolean DEFAULT false NOT NULL,
    today_deal boolean DEFAULT false NOT NULL,
    approved boolean DEFAULT false NOT NULL,
    status character varying(255) DEFAULT 'disabled'::character varying NOT NULL,
    map_embed text,
    video_embed text,
    short_video_url text,
    extra_data text,
    created_by character varying(255),
    views integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.properties OWNER TO realestateai;

--
-- Name: properties_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.properties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.properties_id_seq OWNER TO realestateai;

--
-- Name: properties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.properties_id_seq OWNED BY public.properties.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO realestateai;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO realestateai;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO realestateai;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO realestateai;

--
-- Name: societies; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.societies (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    city_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    meta_data json,
    map_data json,
    overview text,
    detail text,
    has_residential_plots boolean DEFAULT false NOT NULL,
    has_commercial_plots boolean DEFAULT false NOT NULL,
    has_houses boolean DEFAULT false NOT NULL,
    has_apartments boolean DEFAULT false NOT NULL,
    has_farm_houses boolean DEFAULT false NOT NULL,
    has_shop boolean DEFAULT false NOT NULL,
    property_types json,
    created_by integer NOT NULL,
    status character varying(20) DEFAULT 'enabled'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.societies OWNER TO realestateai;

--
-- Name: societies_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.societies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.societies_id_seq OWNER TO realestateai;

--
-- Name: societies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.societies_id_seq OWNED BY public.societies.id;


--
-- Name: society_pages; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.society_pages (
    id bigint NOT NULL,
    user_id bigint,
    slug character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    heading character varying(255) NOT NULL,
    detail text NOT NULL,
    meta_keywords text,
    meta_description text,
    domain character varying(100) DEFAULT 'advice.pk'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.society_pages OWNER TO realestateai;

--
-- Name: COLUMN society_pages.slug; Type: COMMENT; Schema: public; Owner: realestateai
--

COMMENT ON COLUMN public.society_pages.slug IS 'SEO slug like nova-city-islamabad';


--
-- Name: COLUMN society_pages.domain; Type: COMMENT; Schema: public; Owner: realestateai
--

COMMENT ON COLUMN public.society_pages.domain IS 'Domain the page belongs to, e.g., advice.pk';


--
-- Name: society_pages_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.society_pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.society_pages_id_seq OWNER TO realestateai;

--
-- Name: society_pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.society_pages_id_seq OWNED BY public.society_pages.id;


--
-- Name: sub_sectors; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.sub_sectors (
    id bigint NOT NULL,
    society_id bigint NOT NULL,
    parent_id bigint,
    name character varying(255),
    title character varying(255),
    slug character varying(255),
    meta_keywords character varying(255),
    meta_detail text,
    detail text,
    block character varying(20),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.sub_sectors OWNER TO realestateai;

--
-- Name: sub_sectors_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.sub_sectors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sub_sectors_id_seq OWNER TO realestateai;

--
-- Name: sub_sectors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.sub_sectors_id_seq OWNED BY public.sub_sectors.id;


--
-- Name: sub_societies; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.sub_societies (
    id bigint NOT NULL,
    society_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    type character varying(255),
    meta_keywords character varying(255),
    meta_detail character varying(255),
    detail text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.sub_societies OWNER TO realestateai;

--
-- Name: sub_societies_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.sub_societies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sub_societies_id_seq OWNER TO realestateai;

--
-- Name: sub_societies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.sub_societies_id_seq OWNED BY public.sub_societies.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: realestateai
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    two_factor_secret text,
    two_factor_recovery_codes text,
    two_factor_confirmed_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO realestateai;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: realestateai
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO realestateai;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: realestateai
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: blogs id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.blogs ALTER COLUMN id SET DEFAULT nextval('public.blogs_id_seq'::regclass);


--
-- Name: cities id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.cities ALTER COLUMN id SET DEFAULT nextval('public.cities_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: media id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.media ALTER COLUMN id SET DEFAULT nextval('public.media_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: projects id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.projects ALTER COLUMN id SET DEFAULT nextval('public.projects_id_seq'::regclass);


--
-- Name: properties id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.properties ALTER COLUMN id SET DEFAULT nextval('public.properties_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: societies id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.societies ALTER COLUMN id SET DEFAULT nextval('public.societies_id_seq'::regclass);


--
-- Name: society_pages id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.society_pages ALTER COLUMN id SET DEFAULT nextval('public.society_pages_id_seq'::regclass);


--
-- Name: sub_sectors id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_sectors ALTER COLUMN id SET DEFAULT nextval('public.sub_sectors_id_seq'::regclass);


--
-- Name: sub_societies id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_societies ALTER COLUMN id SET DEFAULT nextval('public.sub_societies_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: blogs; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.blogs (id, user_id, title, slug, heading, detail, meta_keywords, meta_description, domain, deleted_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.cache (key, value, expiration) FROM stdin;
laravel_cache_063ef49938baacec16aac018d4d882bdfae92a21:timer	i:1750533050;	1750533050
laravel_cache_4a3bbe474b113b384f00987621b3db46a2787965:timer	i:1749585627;	1749585627
laravel_cache_329127ad28f6846e5dd6444ef7fa3620f91dff6d:timer	i:1750591812;	1750591812
laravel_cache_063ef49938baacec16aac018d4d882bdfae92a21	i:2;	1750533050
laravel_cache_0c6044b6a0f53c92baaf084a0bfda08d17290c6d:timer	i:1749553583;	1749553583
laravel_cache_c0101d6697be5e5895af44e93561a0d51ef31178:timer	i:1749565196;	1749565196
laravel_cache_4a3bbe474b113b384f00987621b3db46a2787965	i:1;	1749585627
laravel_cache_187696601af01ff2008f40a259c6759eee1ac3ac	i:2;	1749585627
laravel_cache_0c6044b6a0f53c92baaf084a0bfda08d17290c6d	i:4;	1749553583
laravel_cache_1184627e3db2c246d44bce891e18329b3870de7e:timer	i:1749559725;	1749559725
laravel_cache_13d801d7206e578594f7ab8db5c565f70bfc2b40:timer	i:1749813789;	1749813789
laravel_cache_c0101d6697be5e5895af44e93561a0d51ef31178	i:4;	1749565196
laravel_cache_c57329c5be738e4f676f86b774b97be513693521:timer	i:1749567237;	1749567237
laravel_cache_1184627e3db2c246d44bce891e18329b3870de7e	i:4;	1749559725
laravel_cache_ed1d1e33dee21feab768c530fae9ef4d05331599:timer	i:1749585627;	1749585627
laravel_cache_c57329c5be738e4f676f86b774b97be513693521	i:2;	1749567237
laravel_cache_302741d18f95aebf6bf8fd8ba5acc5713569a501:timer	i:1749560644;	1749560644
laravel_cache_ed1d1e33dee21feab768c530fae9ef4d05331599	i:1;	1749585627
laravel_cache_bb54c8608434a63c11a3bbeba71e420ec16e6925:timer	i:1749585629;	1749585629
laravel_cache_8e752fdb69d74ec943dbf2711f6b9101414d8747:timer	i:1749576670;	1749576670
laravel_cache_9a3122782931fd54532f97e97439bac58c3c466c:timer	i:1749585629;	1749585629
laravel_cache_302741d18f95aebf6bf8fd8ba5acc5713569a501	i:4;	1749560644
laravel_cache_9a3122782931fd54532f97e97439bac58c3c466c	i:1;	1749585629
laravel_cache_8e752fdb69d74ec943dbf2711f6b9101414d8747	i:4;	1749576670
laravel_cache_a52e26538b45e5e11ec79fcb15c1df50005108c5	i:4;	1749817440
laravel_cache_ce39dc2b5f77fba62cdfc290f40ab3967b8dfd3f:timer	i:1749412207;	1749412207
laravel_cache_ef6922e3348dbb3041000be0d2e47950ad226cc9:timer	i:1749549766;	1749549766
laravel_cache_8342a97a94b61ae1c2865a4a2df1b03f78464ea5:timer	i:1749737483;	1749737483
laravel_cache_bb54c8608434a63c11a3bbeba71e420ec16e6925	i:3;	1749585629
laravel_cache_ad5d70f7a88b5127f09f495ace82edca1954785f:timer	i:1749589886;	1749589886
laravel_cache_ef6922e3348dbb3041000be0d2e47950ad226cc9	i:4;	1749549766
laravel_cache_ce39dc2b5f77fba62cdfc290f40ab3967b8dfd3f	i:4;	1749412207
laravel_cache_ab394e39e9ec5c03d5cba452d8187410141dac0b:timer	i:1749549777;	1749549777
laravel_cache_4b6f6432ed27942135f3e8c1b5c9f60225013ecc:timer	i:1749577051;	1749577051
laravel_cache_ab394e39e9ec5c03d5cba452d8187410141dac0b	i:4;	1749549778
laravel_cache_8342a97a94b61ae1c2865a4a2df1b03f78464ea5	i:2;	1749737483
laravel_cache_001f0951bd9333e7a5e21aa7cac0e3ce53b0691a:timer	i:1749905864;	1749905864
laravel_cache_4b6f6432ed27942135f3e8c1b5c9f60225013ecc	i:4;	1749577051
laravel_cache_3b435ae9262f400e5f57b06e4604f1df9fade096:timer	i:1749577196;	1749577196
laravel_cache_13d801d7206e578594f7ab8db5c565f70bfc2b40	i:3;	1749813789
laravel_cache_ad5d70f7a88b5127f09f495ace82edca1954785f	i:3;	1749589886
laravel_cache_3b435ae9262f400e5f57b06e4604f1df9fade096	i:4;	1749577196
laravel_cache_187696601af01ff2008f40a259c6759eee1ac3ac:timer	i:1749585627;	1749585627
laravel_cache_395ee57c0ee2876cafa80f98b106bb4f520720cd:timer	i:1749652590;	1749652590
laravel_cache_4c3fcd529d8f14e0ad463e6715e2a7ef4a3452f0	i:2;	1750008718
laravel_cache_a52e26538b45e5e11ec79fcb15c1df50005108c5:timer	i:1749817440;	1749817440
laravel_cache_deca0fd89941ea02d19b59855f687814ae496ee5:timer	i:1749915547;	1749915547
laravel_cache_001f0951bd9333e7a5e21aa7cac0e3ce53b0691a	i:4;	1749905864
laravel_cache_395ee57c0ee2876cafa80f98b106bb4f520720cd	i:4;	1749652590
laravel_cache_8eeeae1efbbc621d0b98aeed8419e6d1957ba0b7:timer	i:1749710597;	1749710597
laravel_cache_bc375e334191ff735f5966fdab6c2be62f3e19ae	i:4;	1749958974
laravel_cache_0eb2e02775d4e87b1928d503449dbd824afc1f6c	i:4;	1749958972
laravel_cache_351097794bf4ca71bbbf27837fecc3bf70562a38:timer	i:1749958973;	1749958973
laravel_cache_8eeeae1efbbc621d0b98aeed8419e6d1957ba0b7	i:4;	1749710597
laravel_cache_b846ed1a5bb82e7b0f8275a7f64c47141006bd56:timer	i:1749710686;	1749710686
laravel_cache_deca0fd89941ea02d19b59855f687814ae496ee5	i:4;	1749915547
laravel_cache_2ab447073f89094f449515931691d3eec91a7237:timer	i:1749958971;	1749958971
laravel_cache_b846ed1a5bb82e7b0f8275a7f64c47141006bd56	i:4;	1749710686
laravel_cache_2ab447073f89094f449515931691d3eec91a7237	i:4;	1749958971
laravel_cache_0eb2e02775d4e87b1928d503449dbd824afc1f6c:timer	i:1749958972;	1749958972
laravel_cache_351097794bf4ca71bbbf27837fecc3bf70562a38	i:4;	1749958973
laravel_cache_bc375e334191ff735f5966fdab6c2be62f3e19ae:timer	i:1749958974;	1749958974
laravel_cache_4c3fcd529d8f14e0ad463e6715e2a7ef4a3452f0:timer	i:1750008718;	1750008718
laravel_cache_647c4587e463eefc3064f585d245fc524b946cfe:timer	i:1750063034;	1750063034
laravel_cache_647c4587e463eefc3064f585d245fc524b946cfe	i:4;	1750063034
laravel_cache_de9b10020c4bdc401c712c76c9dbaa0f13fa1699:timer	i:1750070166;	1750070166
laravel_cache_de9b10020c4bdc401c712c76c9dbaa0f13fa1699	i:4;	1750070166
laravel_cache_0ab2fe710d01b66f4eeed47c71b96df67a786131:timer	i:1750072062;	1750072062
laravel_cache_0ab2fe710d01b66f4eeed47c71b96df67a786131	i:1;	1750072062
laravel_cache_c16d9903dfb66c74055acc6b35c7794efa45eb2f:timer	i:1750096494;	1750096494
laravel_cache_c16d9903dfb66c74055acc6b35c7794efa45eb2f	i:4;	1750096494
laravel_cache_76549146c64fca6cc3ec0e84415657e6a21fd7b2:timer	i:1750156914;	1750156914
laravel_cache_76549146c64fca6cc3ec0e84415657e6a21fd7b2	i:2;	1750156914
laravel_cache_baf972141f11bc58b8e230bb7a63d1130a076e5f:timer	i:1750245705;	1750245705
laravel_cache_329127ad28f6846e5dd6444ef7fa3620f91dff6d	i:4;	1750591812
laravel_cache_baf972141f11bc58b8e230bb7a63d1130a076e5f	i:1;	1750245705
laravel_cache_c04df38871c44df62b9e0f51b8aaf1dca5d2df2b:timer	i:1750677446;	1750677446
laravel_cache_61de3963c12f2b1e39056d207a02c89f408da7a4:timer	i:1750258922;	1750258922
laravel_cache_53b811ea70588e53477487d91bb1426fa8dbd998:timer	i:1750942483;	1750942483
laravel_cache_c04df38871c44df62b9e0f51b8aaf1dca5d2df2b	i:1;	1750677446
laravel_cache_df8d8d924869e84ff54e75bd410b4c157a7c583b:timer	i:1750745371;	1750745371
laravel_cache_53b811ea70588e53477487d91bb1426fa8dbd998	i:1;	1750942483
laravel_cache_61de3963c12f2b1e39056d207a02c89f408da7a4	i:7;	1750258922
laravel_cache_da87325e459ac89a5619b49e122569846b5ca459	i:2;	1750942483
laravel_cache_df8d8d924869e84ff54e75bd410b4c157a7c583b	i:4;	1750745371
laravel_cache_2e074ffa4a387143762caf8cde45b8a1b19491d8:timer	i:1750752397;	1750752397
laravel_cache_87c133be3e2f2503b8ee8d4d93739d6f1577adaf:timer	i:1750943507;	1750943507
laravel_cache_0872994e8ae07ce5ecbade9eff116a13b636a019	i:4;	1751183225
laravel_cache_75c1983c497beef6b8df3bd0a75092a8483f025e:timer	i:1750346569;	1750346569
laravel_cache_2e074ffa4a387143762caf8cde45b8a1b19491d8	i:4;	1750752397
laravel_cache_75c1983c497beef6b8df3bd0a75092a8483f025e	i:4;	1750346569
laravel_cache_e9ac7b2fe5193474b84d17a3379a3b5b1558bf7a:timer	i:1751183266;	1751183266
laravel_cache_87c133be3e2f2503b8ee8d4d93739d6f1577adaf	i:4;	1750943507
laravel_cache_a32e382a3065d97b53bc14e57cedbae9485a93d1:timer	i:1750793390;	1750793390
laravel_cache_ad45bec6abd2383f5383b0e1d5c6a4d8eb5889cb:timer	i:1750495670;	1750495670
laravel_cache_a32e382a3065d97b53bc14e57cedbae9485a93d1	i:2;	1750793390
laravel_cache_cf592c2024055ba264f5dbf230b42c39a5ba6e78:timer	i:1750798969;	1750798969
laravel_cache_ad45bec6abd2383f5383b0e1d5c6a4d8eb5889cb	i:4;	1750495670
laravel_cache_04169ffdbc488bc8b1b2cc6b2460a62e2d77d208:timer	i:1750508343;	1750508343
laravel_cache_af02a0acd21a181e5d7094abcf09ce71d86197f9	i:4;	1751085210
laravel_cache_cf592c2024055ba264f5dbf230b42c39a5ba6e78	i:1;	1750798969
laravel_cache_04169ffdbc488bc8b1b2cc6b2460a62e2d77d208	i:4;	1750508343
laravel_cache_127218205940c46e1f34176a7bb9131a297441e7:timer	i:1750833324;	1750833324
laravel_cache_7ca6b58c7c845ab8b8a72cddc802eb264b1b21d9:timer	i:1751027285;	1751027285
laravel_cache_127218205940c46e1f34176a7bb9131a297441e7	i:4;	1750833324
laravel_cache_6c7285f305a20ec6e9c40ca1718072a6a8ab1706:timer	i:1750857789;	1750857789
laravel_cache_7ab96e895e4a160e5d8de85c9e3c3ec1fee01002	i:4;	1751085211
laravel_cache_6c7285f305a20ec6e9c40ca1718072a6a8ab1706	i:4;	1750857789
laravel_cache_40d514ea0819f297b50cef42398f7bbb4394e5dc:timer	i:1750942483;	1750942483
laravel_cache_40d514ea0819f297b50cef42398f7bbb4394e5dc	i:1;	1750942483
laravel_cache_da87325e459ac89a5619b49e122569846b5ca459:timer	i:1750942483;	1750942483
laravel_cache_7ca6b58c7c845ab8b8a72cddc802eb264b1b21d9	i:4;	1751027285
laravel_cache_d38af90e9c1cee2424b4de58cb9db3fca4beabd7:timer	i:1751085210;	1751085210
laravel_cache_0c8a9320e2bd1d024f223c3a137b43a02bfa676f:timer	i:1751085210;	1751085210
laravel_cache_c9a6eb3174d7af3ad9fd422466b76c2dda2a5b9c:timer	i:1751097857;	1751097857
laravel_cache_e9ac7b2fe5193474b84d17a3379a3b5b1558bf7a	i:4;	1751183266
laravel_cache_c9a6eb3174d7af3ad9fd422466b76c2dda2a5b9c	i:2;	1751097857
laravel_cache_af02a0acd21a181e5d7094abcf09ce71d86197f9:timer	i:1751085210;	1751085210
laravel_cache_fdacfe73775b8fe502928025168a57e7b7f02a01:timer	i:1751290282;	1751290282
laravel_cache_d38af90e9c1cee2424b4de58cb9db3fca4beabd7	i:3;	1751085210
laravel_cache_0c8a9320e2bd1d024f223c3a137b43a02bfa676f	i:4;	1751085210
laravel_cache_7ab96e895e4a160e5d8de85c9e3c3ec1fee01002:timer	i:1751085211;	1751085211
laravel_cache_8c5846a9b3419c552f7a84d593457c5f57bfb554:timer	i:1751167193;	1751167193
laravel_cache_87e2e24feb46c51488b211d831fa08fc1bec5005:timer	i:1751290282;	1751290282
laravel_cache_8c5846a9b3419c552f7a84d593457c5f57bfb554	i:1;	1751167193
laravel_cache_0872994e8ae07ce5ecbade9eff116a13b636a019:timer	i:1751183225;	1751183225
laravel_cache_fafb72c62ee2f6c43d4daea2f21ea75ef4767ae3	i:1;	1751643693
laravel_cache_87e2e24feb46c51488b211d831fa08fc1bec5005	i:1;	1751290282
laravel_cache_d92056d67998ef133df9f201f3464fbc28b0bc93:timer	i:1751290282;	1751290282
laravel_cache_d92056d67998ef133df9f201f3464fbc28b0bc93	i:1;	1751290282
laravel_cache_fdacfe73775b8fe502928025168a57e7b7f02a01	i:2;	1751290282
laravel_cache_a87a1d582ae46e8f96044f644d3432ecce6d295f:timer	i:1751737620;	1751737620
laravel_cache_fafb72c62ee2f6c43d4daea2f21ea75ef4767ae3:timer	i:1751643693;	1751643693
laravel_cache_081bbbfb21459b23da3cd8de7a5e8d885aff877f:timer	i:1751785569;	1751785569
laravel_cache_a87a1d582ae46e8f96044f644d3432ecce6d295f	i:3;	1751737620
laravel_cache_bec48d30e59144653c24960851e39679a9ec6ede:timer	i:1751825209;	1751825209
laravel_cache_081bbbfb21459b23da3cd8de7a5e8d885aff877f	i:2;	1751785569
laravel_cache_bec48d30e59144653c24960851e39679a9ec6ede	i:4;	1751825209
laravel_cache_50fd9519b244fa4f62fcadfd590801b4ecc63762:timer	i:1751892712;	1751892712
laravel_cache_50fd9519b244fa4f62fcadfd590801b4ecc63762	i:2;	1751892712
laravel_cache_cf90fa5ae8da1f3dfc75bc222811f12a3f6e167b:timer	i:1751974854;	1751974854
laravel_cache_8faa9a7fcfa8f5e19212a8beb4e2420f60ec17f5:timer	i:1752033350;	1752033350
laravel_cache_cf90fa5ae8da1f3dfc75bc222811f12a3f6e167b	i:1;	1751974854
laravel_cache_df25485494327e466a7a5e6c8754a944f8c6e43c:timer	i:1752048195;	1752048195
laravel_cache_8faa9a7fcfa8f5e19212a8beb4e2420f60ec17f5	i:3;	1752033350
laravel_cache_df25485494327e466a7a5e6c8754a944f8c6e43c	i:2;	1752048195
laravel_cache_fd12c8548038604b89a2380c5e733d69d4269694:timer	i:1752053385;	1752053385
laravel_cache_fd12c8548038604b89a2380c5e733d69d4269694	i:2;	1752053385
laravel_cache_2f9472c7e05f2bd2f8eca0acd567a984d5f30a37:timer	i:1752146886;	1752146886
laravel_cache_2f9472c7e05f2bd2f8eca0acd567a984d5f30a37	i:2;	1752146886
laravel_cache_ef9c6f4a70463674911495668306eab8fc67e30e:timer	i:1752216102;	1752216102
laravel_cache_featured_properties	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TW9kZWxzXE1lZGlhIjozMzp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJwZ3NxbCI7czo4OiIAKgB0YWJsZSI7czo1OiJtZWRpYSI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE5OntzOjI6ImlkIjtpOjExO3M6MTA6Im1vZGVsX3R5cGUiO3M6MTk6IkFwcFxNb2RlbHNcUHJvcGVydHkiO3M6ODoibW9kZWxfaWQiO2k6NztzOjQ6InV1aWQiO3M6MzY6IjU0MjIwZThkLWY5OWUtNGZkNS05NTg1LTRjNjM2ZTAwOTViMyI7czoxNToiY29sbGVjdGlvbl9uYW1lIjtzOjE0OiJwcm9wZXJ0eV9pbWFnZSI7czo0OiJuYW1lIjtzOjM2OiJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmYiO3M6OToiZmlsZV9uYW1lIjtzOjQwOiJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmYuanBnIjtzOjk6Im1pbWVfdHlwZSI7czoxMDoiaW1hZ2UvanBlZyI7czo0OiJkaXNrIjtzOjY6InB1YmxpYyI7czoxNjoiY29udmVyc2lvbnNfZGlzayI7czo2OiJwdWJsaWMiO3M6NDoic2l6ZSI7aToxNTcyMDU7czoxMzoibWFuaXB1bGF0aW9ucyI7czoyOiJbXSI7czoxNzoiY3VzdG9tX3Byb3BlcnRpZXMiO3M6MjoiW10iO3M6MjE6ImdlbmVyYXRlZF9jb252ZXJzaW9ucyI7czoxNDoieyJ0aHVtYiI6dHJ1ZX0iO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjUwNzk6InsidGh1bWIiOnsidXJscyI6WyJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX190aHVtYl8yNzBfMzYwLmpwZyIsImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX3RodW1iXzIyNV8zMDAuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fdGh1bWJfMTg5XzI1Mi5qcGciXSwiYmFzZTY0c3ZnIjoiZGF0YTppbWFnZVwvc3ZnK3htbDtiYXNlNjQsUENGRVQwTlVXVkJGSUhOMlp5QlFWVUpNU1VNZ0lpMHZMMWN6UXk4dlJGUkVJRk5XUnlBeExqRXZMMFZPSWlBaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdlIzSmhjR2hwWTNNdlUxWkhMekV1TVM5RVZFUXZjM1puTVRFdVpIUmtJajRLUEhOMlp5QjJaWEp6YVc5dVBTSXhMakVpSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh5TURBd0wzTjJaeUlnZUcxc2JuTTZlR3hwYm1zOUltaDBkSEE2THk5M2QzY3Vkek11YjNKbkx6RTVPVGt2ZUd4cGJtc2lJSGh0YkRwemNHRmpaVDBpY0hKbGMyVnlkbVVpSUhnOUlqQWlDaUI1UFNJd0lpQjJhV1YzUW05NFBTSXdJREFnTWpjd0lETTJNQ0krQ2drOGFXMWhaMlVnZDJsa2RHZzlJakkzTUNJZ2FHVnBaMmgwUFNJek5qQWlJSGhzYVc1ck9taHlaV1k5SW1SaGRHRTZhVzFoWjJVdmFuQmxaenRpWVhObE5qUXNMemxxTHpSQlFWRlRhMXBLVW1kQlFrRlJSVUZaUVVKblFVRkVMeTluUVN0Uk1VcEdVVlpTVUZWcWIyZGFNbEYwWVc1Q2JGcDVRakpOVXpSM1NVTm9NV015YkhWYWVVSktVMnRqWjFOc1FrWlNlVUl5VDBSQmNFeERRbXRhVjFwb1pGZDRNRWxJUmpGWlYzaHdaRWhyU3k4NWMwRlJkMEZKUW1kWlNFSm5WVWxDZDJOSVExRnJTVU5uZDFWRVVYZE1RM2QzV2tWb1RWQkdRakJoU0hnMFpFZG9kMk5KUTFGMVNubEJhVXhEVFdOSVEyY3pTMU4zZDAxVVVUQk9Ramh1VDFRd05FMXFkM1ZOZWxGNUx6bHpRVkYzUlVwRFVXdE5RM2QzV1VSUk1GbE5hVVZqU1ZSSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYa3ZPRUZCUlZGblFVdDNRV2RCZDBWcFFVRkpVa0ZSVFZKQlppOUZRVUk0UVVGQlJVWkJVVVZDUVZGRlFrRkJRVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZSUVVGSlFrRjNUVU5DUVUxR1FsRlJSVUZCUVVKbVVVVkRRWGRCUlVWUlZWTkpWRVpDUW1oT1VsbFJZMmxqVWxGNVoxcEhhRU5EVGtOelkwVldWWFJJZDBwRVRtbGpiMGxLUTJoWldFZENhMkZLVTFsdVMwTnJjVTVFVlRKT2VtYzFUMnRPUlZKVldraFRSV3hMVlRGU1ZsWnNaRmxYVm5CcVdrZFdiVm95YUhCaGJrNHdaRmhhTTJWSWJEWm5ORk5HYUc5bFNXbFpjVk5yTlZOV2JIQmxXVzFhY1dsdk5sTnNjSEZsYjNGaGNYbHpOMU14ZEhKbE5IVmlja04zT0ZSR2VITm1TWGxqY2xNd09WUldNWFJtV1RKa2NtZzBkVkJyTldWaWJqWlBibkU0Wmt4Nk9WQllNamt2YWpVcmRpOUZRVUk0UWtGQlRVSkJVVVZDUVZGRlFrRlJSVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZTUVVGSlFrRm5VVVZCZDFGSVFsRlJSVUZCUlVOa2QwRkNRV2ROVWtKQlZXaE5VVmxUVVZaRlNGbFlSVlJKYWt0Q1EwSlNRMnRoUjNoM1VXdHFUVEZNZDBaWFNua3dVVzlYU2tSVWFFcG1SVmhIUW10aFNtbGpiMHRUYnpGT2FtTTBUMVJ3UkZKRlZrZFNNR2hLVTJ4T1ZWWldXbGhYUm14aFdUSlNiRnB0Wkc5aFYzQjZaRWhXTW1RemFEVmxiMHRFYUVsWFIyZzBhVXBwY0V0VWJFcFhWMncxYVZwdGNVdHFjRXRYYlhBMmFYQnhja3Q2ZEV4WE1uUTNhVFYxYzB4RWVFMVlSM2c0YWtwNWRFeFVNVTVZVnpFNWFsb3lkVXhxTlU5WWJUVXJhbkEyZGt4Nk9WQllNamt2YWpVcmRpOWhRVUYzUkVGUlFVTkZVVTFTUVVRNFFURTFka04xYlRKNFFsZFBjVEJ0YWxkSE4wdDRNVEZXTDJKVFQyWnJSbGxyT1hSTmNtWmtUbHBQWVZSelZscHpjVEk1Ym1KWE4yZG9VbFZ6TWtaU2JYaG5WWFI0UVRCTlVXdG1hWEZXTTJWd09XZGphelI0VldVd2RYSk5jRkprTjI1aU16RTNSbUYyZEdOblpsZHpVRlZPVjJoaVlVVlpXbm95Y2tZNFpHWmlibll4VXpONlp5dHNXbVZ0WVVwbVRuUmxaVkV2VTNGc1JuWlJVMnRyZW1VeFV6aFdORVZWYm5KWVJTdExZakJTVjFjeVNpOXlXRmw2TmxjM1FVSnFhMEZXTlM4ME0zUjRZbEUwUjJWaE1GWkxVRXhrTjJzck1HWk9XVGxsTVhSV1RqSkRVbFpSVTNKblFWWmpNV292YWpWeVNGVnVlbkZpTTBwYVltUnBlVEUxT1RoUldXazVjVWQ0TUhJd1ExaHBUVlo0ZG1wM1JDdDVlSGhSTlU1TGQwdExkbU12T1dzOUlqNEtDVHd2YVcxaFoyVStDand2YzNablBnPT0ifSwibWVkaWFfbGlicmFyeV9vcmlnaW5hbCI6eyJ1cmxzIjpbImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfOTYwXzEyODAuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF84MDNfMTA3MS5qcGciLCJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzY3Ml84OTYuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF81NjJfNzQ5LmpwZyIsImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNDcwXzYyNy5qcGciLCJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzM5M181MjQuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8zMjlfNDM5LmpwZyIsImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMjc1XzM2Ny5qcGciXSwiYmFzZTY0c3ZnIjoiZGF0YTppbWFnZVwvc3ZnK3htbDtiYXNlNjQsUENGRVQwTlVXVkJGSUhOMlp5QlFWVUpNU1VNZ0lpMHZMMWN6UXk4dlJGUkVJRk5XUnlBeExqRXZMMFZPSWlBaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdlIzSmhjR2hwWTNNdlUxWkhMekV1TVM5RVZFUXZjM1puTVRFdVpIUmtJajRLUEhOMlp5QjJaWEp6YVc5dVBTSXhMakVpSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh5TURBd0wzTjJaeUlnZUcxc2JuTTZlR3hwYm1zOUltaDBkSEE2THk5M2QzY3Vkek11YjNKbkx6RTVPVGt2ZUd4cGJtc2lJSGh0YkRwemNHRmpaVDBpY0hKbGMyVnlkbVVpSUhnOUlqQWlDaUI1UFNJd0lpQjJhV1YzUW05NFBTSXdJREFnT1RZd0lERXlPREFpUGdvSlBHbHRZV2RsSUhkcFpIUm9QU0k1TmpBaUlHaGxhV2RvZEQwaU1USTRNQ0lnZUd4cGJtczZhSEpsWmowaVpHRjBZVHBwYldGblpTOXFjR1ZuTzJKaGMyVTJOQ3d2T1dvdk5FRkJVVk5yV2twU1owRkNRVkZGUVZsQlFtZEJRVVF2TDJkQksxRXhTa1pSVmxKUVZXcHZaMW95VVhSaGJrSnNXbmxDTWsxVE5IZEpRMmd4WXpKc2RWcDVRa3BUYTJOblUyeENSbEo1UWpKUFJFRndURU5DYTFwWFdtaGtWM2d3U1VoR01WbFhlSEJrU0d0TEx6bHpRVkYzUVVsQ1oxbElRbWRWU1VKM1kwaERVV3RKUTJkM1ZVUlJkMHhEZDNkYVJXaE5VRVpDTUdGSWVEUmtSMmgzWTBsRFVYVktlVUZwVEVOTlkwaERaek5MVTNkM1RWUlJNRTVDT0c1UFZEQTBUV3AzZFUxNlVYa3ZPWE5CVVhkRlNrTlJhMDFEZDNkWlJGRXdXVTFwUldOSlZFbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplUzg0UVVGRlVXZEJTM2RCWjBGM1JXbEJRVWxTUVZGTlVrRm1MMFZCUWpoQlFVRkZSa0ZSUlVKQlVVVkNRVUZCUVVGQlFVRkJRVUZDUVdkTlJVSlJXVWhEUVd0TFF5OHZSVUZNVlZGQlFVbENRWGROUTBKQlRVWkNVVkZGUVVGQlFtWlJSVU5CZDBGRlJWRlZVMGxVUmtKQ2FFNVNXVkZqYVdOU1VYbG5Xa2RvUTBOT1EzTmpSVlpWZEVoM1NrUk9hV052U1VwRGFGbFlSMEpyWVVwVFdXNUxRMnR4VGtSVk1rNTZaelZQYTA1RlVsVmFTRk5GYkV0Vk1WSldWbXhrV1ZkV2NHcGFSMVp0V2pKb2NHRnVUakJrV0ZvelpVaHNObWMwVTBab2IyVkphVmx4VTJzMVUxWnNjR1ZaYlZweGFXODJVMnh3Y1dWdmNXRnhlWE0zVXpGMGNtVTBkV0p5UTNjNFZFWjRjMlpKZVdOeVV6QTVWRll4ZEdaWk1tUnlhRFIxVUdzMVpXSnVOazl1Y1RobVRIbzVVRmd5T1M5cU5TdDJMMFZCUWpoQ1FVRk5Ra0ZSUlVKQlVVVkNRVkZGUVVGQlFVRkJRVUZDUVdkTlJVSlJXVWhEUVd0TFF5OHZSVUZNVlZKQlFVbENRV2RSUlVGM1VVaENVVkZGUVVGRlEyUjNRVUpCWjAxU1FrRlZhRTFSV1ZOUlZrVklXVmhGVkVscVMwSkRRbEpEYTJGSGVIZFJhMnBOTVV4M1JsZEtlVEJSYjFkS1JGUm9TbVpGV0VkQ2EyRkthV052UzFOdk1VNXFZelJQVkhCRVVrVldSMUl3YUVwVGJFNVZWbFphV0ZkR2JHRlpNbEpzV20xa2IyRlhjSHBrU0ZZeVpETm9OV1Z2UzBSb1NWZEhhRFJwU21sd1MxUnNTbGRYYkRWcFdtMXhTMnB3UzFkdGNEWnBjSEZ5UzNwMFRGY3lkRGRwTlhWelRFUjRUVmhIZURocVNubDBURlF4VGxoWE1UbHFXakoxVEdvMVQxaHROU3RxY0RaMlRIbzVVRmd5T1M5cU5TdDJMMkZCUVhkRVFWRkJRMFZSVFZKQlJEaEJNVFYyUTIxdE1uaENWMDl4TUcxcE1rSmlTV3BHWkZabU1qQnFialZDVjB4UVlsUkxNek5VVjFSdGF6ZEdWMkpMYkhaYVZ6RnpORWxWVmt4T2RGWkhZa2RDVXpORlJGRjRRMUlyUzNCWWJEUnVNa0pwVkdwR1VqZFNUbGRhVTJrM00xSXlPVGxsZUZkeU4xaFpSRFl4YURab2NUaE1ZbEZxUkZCMFYwdzBOaXN6ZG1aeGJIWnVRamxMZVRsTk1GTXJZbUV3T0doeGNIaGpkRUZWYjNCdE9YRnNOSEozU1hCT1kxUTBjSFpDUmxvM1dYQk5aWFJrYWxCd1luTkJTRTlSUWxodUwwRkpNM1I0WWxKQlJGQk9ZVXRzU0d4MU9YbFFZVkJ0YzJveEwxZDNjSFYzVTBKV1RWTnlha0Z4TlhKSUwwaDZWMUZ3VUc1WmNIWmpWRXhVYzFkWGRsQXZhVVJGV0hSV1lraFRkbEZLWlVWR1kxbzBPRUV2YzNOalZVOVVVM05LVWpGMVppOHlVVDA5SWo0S0NUd3ZhVzFoWjJVK0Nqd3ZjM1puUGc9PSJ9fSI7czoxMjoib3JkZXJfY29sdW1uIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNS0wNS0zMSAxNDozOTowNiI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNi0wNiAwMDowNDowNyI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTk6e3M6MjoiaWQiO2k6MTE7czoxMDoibW9kZWxfdHlwZSI7czoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI7czo4OiJtb2RlbF9pZCI7aTo3O3M6NDoidXVpZCI7czozNjoiNTQyMjBlOGQtZjk5ZS00ZmQ1LTk1ODUtNGM2MzZlMDA5NWIzIjtzOjE1OiJjb2xsZWN0aW9uX25hbWUiO3M6MTQ6InByb3BlcnR5X2ltYWdlIjtzOjQ6Im5hbWUiO3M6MzY6ImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZiI7czo5OiJmaWxlX25hbWUiO3M6NDA6ImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZi5qcGciO3M6OToibWltZV90eXBlIjtzOjEwOiJpbWFnZS9qcGVnIjtzOjQ6ImRpc2siO3M6NjoicHVibGljIjtzOjE2OiJjb252ZXJzaW9uc19kaXNrIjtzOjY6InB1YmxpYyI7czo0OiJzaXplIjtpOjE1NzIwNTtzOjEzOiJtYW5pcHVsYXRpb25zIjtzOjI6IltdIjtzOjE3OiJjdXN0b21fcHJvcGVydGllcyI7czoyOiJbXSI7czoyMToiZ2VuZXJhdGVkX2NvbnZlcnNpb25zIjtzOjE0OiJ7InRodW1iIjp0cnVlfSI7czoxNzoicmVzcG9uc2l2ZV9pbWFnZXMiO3M6NTA3OToieyJ0aHVtYiI6eyJ1cmxzIjpbImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX3RodW1iXzI3MF8zNjAuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fdGh1bWJfMjI1XzMwMC5qcGciLCJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX190aHVtYl8xODlfMjUyLmpwZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdNamN3SURNMk1DSStDZ2s4YVcxaFoyVWdkMmxrZEdnOUlqSTNNQ0lnYUdWcFoyaDBQU0l6TmpBaUlIaHNhVzVyT21oeVpXWTlJbVJoZEdFNmFXMWhaMlV2YW5CbFp6dGlZWE5sTmpRc0x6bHFMelJCUVZGVGExcEtVbWRCUWtGUlJVRlpRVUpuUVVGRUx5OW5RU3RSTVVwR1VWWlNVRlZxYjJkYU1sRjBZVzVDYkZwNVFqSk5VelIzU1VOb01XTXliSFZhZVVKS1UydGpaMU5zUWtaU2VVSXlUMFJCY0V4RFFtdGFWMXBvWkZkNE1FbElSakZaVjNod1pFaHJTeTg1YzBGUmQwRkpRbWRaU0VKblZVbENkMk5JUTFGclNVTm5kMVZFVVhkTVEzZDNXa1ZvVFZCR1FqQmhTSGcwWkVkb2QyTkpRMUYxU25sQmFVeERUV05JUTJjelMxTjNkMDFVVVRCT1FqaHVUMVF3TkUxcWQzVk5lbEY1THpselFWRjNSVXBEVVd0TlEzZDNXVVJSTUZsTmFVVmpTVlJKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hrdk9FRkJSVkZuUVV0M1FXZEJkMFZwUVVGSlVrRlJUVkpCWmk5RlFVSTRRVUZCUlVaQlVVVkNRVkZGUWtGQlFVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlJRVUZKUWtGM1RVTkNRVTFHUWxGUlJVRkJRVUptVVVWRFFYZEJSVVZSVlZOSlZFWkNRbWhPVWxsUlkybGpVbEY1WjFwSGFFTkRUa056WTBWV1ZYUklkMHBFVG1samIwbEtRMmhaV0VkQ2EyRktVMWx1UzBOcmNVNUVWVEpPZW1jMVQydE9SVkpWV2toVFJXeExWVEZTVmxac1pGbFhWbkJxV2tkV2JWb3lhSEJoYms0d1pGaGFNMlZJYkRabk5GTkdhRzlsU1dsWmNWTnJOVk5XYkhCbFdXMWFjV2x2TmxOc2NIRmxiM0ZoY1hsek4xTXhkSEpsTkhWaWNrTjNPRlJHZUhObVNYbGpjbE13T1ZSV01YUm1XVEprY21nMGRWQnJOV1ZpYmpaUGJuRTRaa3g2T1ZCWU1qa3ZhalVyZGk5RlFVSTRRa0ZCVFVKQlVVVkNRVkZGUWtGUlJVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlNRVUZKUWtGblVVVkJkMUZJUWxGUlJVRkJSVU5rZDBGQ1FXZE5Va0pCVldoTlVWbFRVVlpGU0ZsWVJWUkpha3RDUTBKU1EydGhSM2gzVVd0cVRURk1kMFpYU25rd1VXOVhTa1JVYUVwbVJWaEhRbXRoU21samIwdFRiekZPYW1NMFQxUndSRkpGVmtkU01HaEtVMnhPVlZaV1dsaFhSbXhoV1RKU2JGcHRaRzloVjNCNlpFaFdNbVF6YURWbGIwdEVhRWxYUjJnMGFVcHBjRXRVYkVwWFYydzFhVnB0Y1V0cWNFdFhiWEEyYVhCeGNrdDZkRXhYTW5RM2FUVjFjMHhFZUUxWVIzZzRha3A1ZEV4VU1VNVlWekU1YWxveWRVeHFOVTlZYlRVcmFuQTJka3g2T1ZCWU1qa3ZhalVyZGk5aFFVRjNSRUZSUVVORlVVMVNRVVE0UVRFMWRrTjFiVEo0UWxkUGNUQnRhbGRITjB0NE1URldMMkpUVDJaclJsbHJPWFJOY21aa1RscFBZVlJ6VmxwemNUSTVibUpYTjJkb1VsVnpNa1pTYlhoblZYUjRRVEJOVVd0bWFYRldNMlZ3T1dkamF6UjRWV1V3ZFhKTmNGSmtOMjVpTXpFM1JtRjJkR05uWmxkelVGVk9WMmhpWVVWWldub3lja1k0WkdaaWJuWXhVek42Wnl0c1dtVnRZVXBtVG5SbFpWRXZVM0ZzUm5aUlUydHJlbVV4VXpoV05FVlZibkpZUlN0TFlqQlNWMWN5U2k5eVdGbDZObGMzUVVKcWEwRldOUzgwTTNSNFlsRTBSMlZoTUZaTFVFeGtOMnNyTUdaT1dUbGxNWFJXVGpKRFVsWlJVM0puUVZaak1Xb3ZhalZ5U0ZWdWVuRmlNMHBhWW1ScGVURTFPVGhSV1drNWNVZDRNSEl3UTFocFRWWjRkbXAzUkN0NWVIaFJOVTVMZDB0TGRtTXZPV3M5SWo0S0NUd3ZhVzFoWjJVK0Nqd3ZjM1puUGc9PSJ9LCJtZWRpYV9saWJyYXJ5X29yaWdpbmFsIjp7InVybHMiOlsiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF85NjBfMTI4MC5qcGciLCJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzgwM18xMDcxLmpwZyIsImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNjcyXzg5Ni5qcGciLCJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzU2Ml83NDkuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF80NzBfNjI3LmpwZyIsImJiNDZjYzlmLTI0NDktNGJiYy1hZDIyLTBjYmE2ZGU5NmQyZl9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMzkzXzUyNC5qcGciLCJiYjQ2Y2M5Zi0yNDQ5LTRiYmMtYWQyMi0wY2JhNmRlOTZkMmZfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzMyOV80MzkuanBnIiwiYmI0NmNjOWYtMjQ0OS00YmJjLWFkMjItMGNiYTZkZTk2ZDJmX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8yNzVfMzY3LmpwZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdPVFl3SURFeU9EQWlQZ29KUEdsdFlXZGxJSGRwWkhSb1BTSTVOakFpSUdobGFXZG9kRDBpTVRJNE1DSWdlR3hwYm1zNmFISmxaajBpWkdGMFlUcHBiV0ZuWlM5cWNHVm5PMkpoYzJVMk5Dd3ZPV292TkVGQlVWTnJXa3BTWjBGQ1FWRkZRVmxCUW1kQlFVUXZMMmRCSzFFeFNrWlJWbEpRVldwdloxb3lVWFJoYmtKc1dubENNazFUTkhkSlEyZ3hZekpzZFZwNVFrcFRhMk5uVTJ4Q1JsSjVRakpQUkVGd1RFTkNhMXBYV21oa1YzZ3dTVWhHTVZsWGVIQmtTR3RMTHpselFWRjNRVWxDWjFsSVFtZFZTVUozWTBoRFVXdEpRMmQzVlVSUmQweERkM2RhUldoTlVFWkNNR0ZJZURSa1IyaDNZMGxEVVhWS2VVRnBURU5OWTBoRFp6TkxVM2QzVFZSUk1FNUNPRzVQVkRBMFRXcDNkVTE2VVhrdk9YTkJVWGRGU2tOUmEwMURkM2RaUkZFd1dVMXBSV05KVkVsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVTODRRVUZGVVdkQlMzZEJaMEYzUldsQlFVbFNRVkZOVWtGbUwwVkJRamhCUVVGRlJrRlJSVUpCVVVWQ1FVRkJRVUZCUVVGQlFVRkNRV2ROUlVKUldVaERRV3RMUXk4dlJVRk1WVkZCUVVsQ1FYZE5RMEpCVFVaQ1VWRkZRVUZCUW1aUlJVTkJkMEZGUlZGVlUwbFVSa0pDYUU1U1dWRmphV05TVVhsbldrZG9RME5PUTNOalJWWlZkRWgzU2tST2FXTnZTVXBEYUZsWVIwSnJZVXBUV1c1TFEydHhUa1JWTWs1Nlp6VlBhMDVGVWxWYVNGTkZiRXRWTVZKV1ZteGtXVmRXY0dwYVIxWnRXakpvY0dGdVRqQmtXRm96WlVoc05tYzBVMFpvYjJWSmFWbHhVMnMxVTFac2NHVlpiVnB4YVc4MlUyeHdjV1Z2Y1dGeGVYTTNVekYwY21VMGRXSnlRM2M0VkVaNGMyWkplV055VXpBNVZGWXhkR1paTW1SeWFEUjFVR3MxWldKdU5rOXVjVGhtVEhvNVVGZ3lPUzlxTlN0MkwwVkJRamhDUVVGTlFrRlJSVUpCVVVWQ1FWRkZRVUZCUVVGQlFVRkNRV2ROUlVKUldVaERRV3RMUXk4dlJVRk1WVkpCUVVsQ1FXZFJSVUYzVVVoQ1VWRkZRVUZGUTJSM1FVSkJaMDFTUWtGVmFFMVJXVk5SVmtWSVdWaEZWRWxxUzBKRFFsSkRhMkZIZUhkUmEycE5NVXgzUmxkS2VUQlJiMWRLUkZSb1NtWkZXRWRDYTJGS2FXTnZTMU52TVU1cVl6UlBWSEJFVWtWV1IxSXdhRXBUYkU1VlZsWmFXRmRHYkdGWk1sSnNXbTFrYjJGWGNIcGtTRll5WkROb05XVnZTMFJvU1ZkSGFEUnBTbWx3UzFSc1NsZFhiRFZwV20xeFMycHdTMWR0Y0RacGNIRnlTM3AwVEZjeWREZHBOWFZ6VEVSNFRWaEhlRGhxU25sMFRGUXhUbGhYTVRscVdqSjFUR28xVDFodE5TdHFjRFoyVEhvNVVGZ3lPUzlxTlN0MkwyRkJRWGRFUVZGQlEwVlJUVkpCUkRoQk1UVjJRMjF0TW5oQ1YwOXhNRzFwTWtKaVNXcEdaRlptTWpCcWJqVkNWMHhRWWxSTE16TlVWMVJ0YXpkR1YySkxiSFphVnpGek5FbFZWa3hPZEZaSFlrZENVek5GUkZGNFExSXJTM0JZYkRSdU1rSnBWR3BHVWpkU1RsZGFVMmszTTFJeU9UbGxlRmR5TjFoWlJEWXhhRFpvY1RoTVlsRnFSRkIwVjB3ME5pc3pkbVp4YkhadVFqbExlVGxOTUZNclltRXdPR2h4Y0hoamRFRlZiM0J0T1hGc05ISjNTWEJPWTFRMGNIWkNSbG8zV1hCTlpYUmthbEJ3WW5OQlNFOVJRbGh1TDBGSk0zUjRZbEpCUkZCT1lVdHNTR3gxT1hsUVlWQnRjMm94TDFkM2NIVjNVMEpXVFZOeWFrRnhOWEpJTDBoNlYxRndVRzVaY0haalZFeFVjMWRYZGxBdmFVUkZXSFJXWWtoVGRsRktaVVZHWTFvME9FRXZjM05qVlU5VVUzTktVakYxWmk4eVVUMDlJajRLQ1R3dmFXMWhaMlUrQ2p3dmMzWm5QZz09In19IjtzOjEyOiJvcmRlcl9jb2x1bW4iO2k6MTtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI1LTA1LTMxIDE0OjM5OjA2IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI1LTA2LTA2IDAwOjA0OjA3IjtzOjEwOiJkZWxldGVkX2F0IjtOO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjQ6e3M6MTM6Im1hbmlwdWxhdGlvbnMiO3M6NToiYXJyYXkiO3M6MTc6ImN1c3RvbV9wcm9wZXJ0aWVzIjtzOjU6ImFycmF5IjtzOjIxOiJnZW5lcmF0ZWRfY29udmVyc2lvbnMiO3M6NToiYXJyYXkiO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjU6ImFycmF5Ijt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjI6e2k6MDtzOjEyOiJvcmlnaW5hbF91cmwiO2k6MTtzOjExOiJwcmV2aWV3X3VybCI7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6Mjc6IgAqAHJlbGF0aW9uQXV0b2xvYWRDYWxsYmFjayI7TjtzOjI2OiIAKgByZWxhdGlvbkF1dG9sb2FkQ29udGV4dCI7TjtzOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czoxMzoidXNlc1VuaXF1ZUlkcyI7YjowO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7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b25zXE1vZGVsc1xDb2xsZWN0aW9uc1xNZWRpYUNvbGxlY3Rpb24iOjQ6e3M6ODoiACoAaXRlbXMiO2E6MTp7aTowO086NDk6IlNwYXRpZVxNZWRpYUxpYnJhcnlcTWVkaWFDb2xsZWN0aW9uc1xNb2RlbHNcTWVkaWEiOjMzOntzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6InBnc3FsIjtzOjg6IgAqAHRhYmxlIjtzOjU6Im1lZGlhIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6MTk6e3M6MjoiaWQiO2k6MTA7czoxMDoibW9kZWxfdHlwZSI7czoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI7czo4OiJtb2RlbF9pZCI7aTo2O3M6NDoidXVpZCI7czozNjoiMGQyNTQ0ODEtYWU3Ni00MTEwLWJkM2EtNDAyMGE3MmZlM2E3IjtzOjE1OiJjb2xsZWN0aW9uX25hbWUiO3M6MTQ6InByb3BlcnR5X2ltYWdlIjtzOjQ6Im5hbWUiO3M6MzY6IjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MCI7czo5OiJmaWxlX25hbWUiO3M6NDA6IjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MC5qcGciO3M6OToibWltZV90eXBlIjtzOjEwOiJpbWFnZS9qcGVnIjtzOjQ6ImRpc2siO3M6NjoicHVibGljIjtzOjE2OiJjb252ZXJzaW9uc19kaXNrIjtzOjY6InB1YmxpYyI7czo0OiJzaXplIjtpOjI0NTU5NTtzOjEzOiJtYW5pcHVsYXRpb25zIjtzOjI6IltdIjtzOjE3OiJjdXN0b21fcHJvcGVydGllcyI7czoyOiJbXSI7czoyMToiZ2VuZXJhdGVkX2NvbnZlcnNpb25zIjtzOjE0OiJ7InRodW1iIjp0cnVlfSI7czoxNzoicmVzcG9uc2l2ZV9pbWFnZXMiO3M6NTQzODoieyJ0aHVtYiI6eyJ1cmxzIjpbIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX3RodW1iXzI3MF8zNjAuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fdGh1bWJfMjI1XzMwMC5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX190aHVtYl8xODlfMjUyLmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX3RodW1iXzE1OF8yMTEuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ01qY3dJRE0yTUNJK0NnazhhVzFoWjJVZ2QybGtkR2c5SWpJM01DSWdhR1ZwWjJoMFBTSXpOakFpSUhoc2FXNXJPbWh5WldZOUltUmhkR0U2YVcxaFoyVXZhbkJsWnp0aVlYTmxOalFzTHpscUx6UkJRVkZUYTFwS1VtZEJRa0ZSUlVGWlFVSm5RVUZFTHk5blFTdFJNVXBHVVZaU1VGVnFiMmRhTWxGMFlXNUNiRnA1UWpKTlV6UjNTVU5vTVdNeWJIVmFlVUpLVTJ0aloxTnNRa1pTZVVJeVQwUkJjRXhEUW10YVYxcG9aRmQ0TUVsSVJqRlpWM2h3WkVoclN5ODVjMEZSZDBGSlFtZFpTRUpuVlVsQ2QyTklRMUZyU1VObmQxVkVVWGRNUTNkM1drVm9UVkJHUWpCaFNIZzBaRWRvZDJOSlExRjFTbmxCYVV4RFRXTklRMmN6UzFOM2QwMVVVVEJPUWpodVQxUXdORTFxZDNWTmVsRjVMemx6UVZGM1JVcERVV3ROUTNkM1dVUlJNRmxOYVVWalNWUkplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGt2T0VGQlJWRm5RVXQzUVdkQmQwVnBRVUZKVWtGUlRWSkJaaTlGUVVJNFFVRkJSVVpCVVVWQ1FWRkZRa0ZCUVVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWUlFVRkpRa0YzVFVOQ1FVMUdRbEZSUlVGQlFVSm1VVVZEUVhkQlJVVlJWVk5KVkVaQ1FtaE9VbGxSWTJsalVsRjVaMXBIYUVORFRrTnpZMFZXVlhSSWQwcEVUbWxqYjBsS1EyaFpXRWRDYTJGS1UxbHVTME5yY1U1RVZUSk9lbWMxVDJ0T1JWSlZXa2hUUld4TFZURlNWbFpzWkZsWFZuQnFXa2RXYlZveWFIQmhiazR3WkZoYU0yVkliRFpuTkZOR2FHOWxTV2xaY1ZOck5WTldiSEJsV1cxYWNXbHZObE5zY0hGbGIzRmhjWGx6TjFNeGRISmxOSFZpY2tOM09GUkdlSE5tU1hsamNsTXdPVlJXTVhSbVdUSmtjbWcwZFZCck5XVmlialpQYm5FNFpreDZPVkJZTWprdmFqVXJkaTlGUVVJNFFrRkJUVUpCVVVWQ1FWRkZRa0ZSUlVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWU1FVRkpRa0ZuVVVWQmQxRklRbEZSUlVGQlJVTmtkMEZDUVdkTlVrSkJWV2hOVVZsVFVWWkZTRmxZUlZSSmFrdENRMEpTUTJ0aFIzaDNVV3RxVFRGTWQwWlhTbmt3VVc5WFNrUlVhRXBtUlZoSFFtdGhTbWxqYjB0VGJ6Rk9hbU0wVDFSd1JGSkZWa2RTTUdoS1UyeE9WVlpXV2xoWFJteGhXVEpTYkZwdFpHOWhWM0I2WkVoV01tUXphRFZsYjB0RWFFbFhSMmcwYVVwcGNFdFViRXBYVjJ3MWFWcHRjVXRxY0V0WGJYQTJhWEJ4Y2t0NmRFeFhNblEzYVRWMWMweEVlRTFZUjNnNGFrcDVkRXhVTVU1WVZ6RTVhbG95ZFV4cU5VOVliVFVyYW5BMmRreDZPVkJZTWprdmFqVXJkaTloUVVGM1JFRlJRVU5GVVUxU1FVUTRRVGhaTDNOUEt6ZFNSMmMyVUdWS2VWbHFLMVpsYjNoU2NuUjZkRVphTVM5UGMxSlFlVVJHVDJoR1ZsbHhWRnByT0ZKVU5YVlhSM0ExTjA1d2MzbHhUVWxqTUd0T2NFNUhNbGRwV1M5b1dHSlhjMnRGT0RONlMwc3pOMkV6YzI1WVFtcFZMMmhYYTNOS1dHaE1iR0V3VGxaV2NGTXlaWEJHVUdSd1JtRnNiRFl4ZVRsNmNVUlVWRmxRU1hKd1luWlVaRGx4T0hGMloxbHliRVJGU1RWVWExbzFjblkwWm5reFQyYzFkR042VUVsd05HSTJjRXN3Ym5JelRsTXdWMFpyTTBnMVZEWXhkRFpUUm1WVmNYQjVTelVyTTJwT2VXOXFTSGx1ZEZoU1lVUmFWRmRqTHpkM05VSnlhM3BIWW5kc1pIbHNiM1ZwVGtocFJXMHlOVWRhUm5GWWJUSnZhbHB6UkhaV1dWRlhOV3hDVFdkNGJYTk9XR0o1SzNCeFNYbFFhamQ0YjNkWFdsbHFSRkZqUzJJd1dqWk9VMnhEY1RkNlYzZ3phbmd5VW5NeFRuWnFla0ZQYjNGdFpGbHNkRlpCWWs5U1YxaHdWSE5WUjFkT1lrcG9hbXRJZW05RU9XRTRja2RVYkZndmFVODFSbGhEVlhGeVZHRXlVQzlhSWo0S0NUd3ZhVzFoWjJVK0Nqd3ZjM1puUGc9PSJ9LCJtZWRpYV9saWJyYXJ5X29yaWdpbmFsIjp7InVybHMiOlsiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF85NjBfMTI4MC5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzgwM18xMDcxLmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNjcyXzg5Ni5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzU2Ml83NDkuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF80NzBfNjI3LmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMzkzXzUyNC5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzMyOV80MzkuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8yNzVfMzY3LmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMjMwXzMwNy5qcGciXSwiYmFzZTY0c3ZnIjoiZGF0YTppbWFnZVwvc3ZnK3htbDtiYXNlNjQsUENGRVQwTlVXVkJGSUhOMlp5QlFWVUpNU1VNZ0lpMHZMMWN6UXk4dlJGUkVJRk5XUnlBeExqRXZMMFZPSWlBaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdlIzSmhjR2hwWTNNdlUxWkhMekV1TVM5RVZFUXZjM1puTVRFdVpIUmtJajRLUEhOMlp5QjJaWEp6YVc5dVBTSXhMakVpSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh5TURBd0wzTjJaeUlnZUcxc2JuTTZlR3hwYm1zOUltaDBkSEE2THk5M2QzY3Vkek11YjNKbkx6RTVPVGt2ZUd4cGJtc2lJSGh0YkRwemNHRmpaVDBpY0hKbGMyVnlkbVVpSUhnOUlqQWlDaUI1UFNJd0lpQjJhV1YzUW05NFBTSXdJREFnT1RZd0lERXlPREFpUGdvSlBHbHRZV2RsSUhkcFpIUm9QU0k1TmpBaUlHaGxhV2RvZEQwaU1USTRNQ0lnZUd4cGJtczZhSEpsWmowaVpHRjBZVHBwYldGblpTOXFjR1ZuTzJKaGMyVTJOQ3d2T1dvdk5FRkJVVk5yV2twU1owRkNRVkZGUVZsQlFtZEJRVVF2TDJkQksxRXhTa1pSVmxKUVZXcHZaMW95VVhSaGJrSnNXbmxDTWsxVE5IZEpRMmd4WXpKc2RWcDVRa3BUYTJOblUyeENSbEo1UWpKUFJFRndURU5DYTFwWFdtaGtWM2d3U1VoR01WbFhlSEJrU0d0TEx6bHpRVkYzUVVsQ1oxbElRbWRWU1VKM1kwaERVV3RKUTJkM1ZVUlJkMHhEZDNkYVJXaE5VRVpDTUdGSWVEUmtSMmgzWTBsRFVYVktlVUZwVEVOTlkwaERaek5MVTNkM1RWUlJNRTVDT0c1UFZEQTBUV3AzZFUxNlVYa3ZPWE5CVVhkRlNrTlJhMDFEZDNkWlJGRXdXVTFwUldOSlZFbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplUzg0UVVGRlVXZEJTM2RCWjBGM1JXbEJRVWxTUVZGTlVrRm1MMFZCUWpoQlFVRkZSa0ZSUlVKQlVVVkNRVUZCUVVGQlFVRkJRVUZDUVdkTlJVSlJXVWhEUVd0TFF5OHZSVUZNVlZGQlFVbENRWGROUTBKQlRVWkNVVkZGUVVGQlFtWlJSVU5CZDBGRlJWRlZVMGxVUmtKQ2FFNVNXVkZqYVdOU1VYbG5Xa2RvUTBOT1EzTmpSVlpWZEVoM1NrUk9hV052U1VwRGFGbFlSMEpyWVVwVFdXNUxRMnR4VGtSVk1rNTZaelZQYTA1RlVsVmFTRk5GYkV0Vk1WSldWbXhrV1ZkV2NHcGFSMVp0V2pKb2NHRnVUakJrV0ZvelpVaHNObWMwVTBab2IyVkphVmx4VTJzMVUxWnNjR1ZaYlZweGFXODJVMnh3Y1dWdmNXRnhlWE0zVXpGMGNtVTBkV0p5UTNjNFZFWjRjMlpKZVdOeVV6QTVWRll4ZEdaWk1tUnlhRFIxVUdzMVpXSnVOazl1Y1RobVRIbzVVRmd5T1M5cU5TdDJMMFZCUWpoQ1FVRk5Ra0ZSUlVKQlVVVkNRVkZGUVVGQlFVRkJRVUZDUVdkTlJVSlJXVWhEUVd0TFF5OHZSVUZNVlZKQlFVbENRV2RSUlVGM1VVaENVVkZGUVVGRlEyUjNRVUpCWjAxU1FrRlZhRTFSV1ZOUlZrVklXVmhGVkVscVMwSkRRbEpEYTJGSGVIZFJhMnBOTVV4M1JsZEtlVEJSYjFkS1JGUm9TbVpGV0VkQ2EyRkthV052UzFOdk1VNXFZelJQVkhCRVVrVldSMUl3YUVwVGJFNVZWbFphV0ZkR2JHRlpNbEpzV20xa2IyRlhjSHBrU0ZZeVpETm9OV1Z2UzBSb1NWZEhhRFJwU21sd1MxUnNTbGRYYkRWcFdtMXhTMnB3UzFkdGNEWnBjSEZ5UzNwMFRGY3lkRGRwTlhWelRFUjRUVmhIZURocVNubDBURlF4VGxoWE1UbHFXakoxVEdvMVQxaHROU3RxY0RaMlRIbzVVRmd5T1M5cU5TdDJMMkZCUVhkRVFWRkJRMFZSVFZKQlJEaEJPRmt2YzFNck4xSkhaelpRWlVwNVdXb3JWbVZ2ZDNoeWRIcDBSbG94TDA5elVsQjVSRVpHUW1VeGFYQk9iVlI0UmxCdE5WbGhibTV6ZFcxNlMyOTNhSHBVV1dKVFlVNXpkRVV6TlZZeU9YSktRbEJPYUd4R1lqbHlZakpVY21odk1WQTBWbkJNUTFscFJYVldjbEV4Vm1GcVRGbzJhMDA1TW10V2NWTjJWM1ZZZFdSUllXRmlRalZHWkV4a1lWbElkRmhzVmpoRVJtTnhXV2hJUzJOcVVFNWxhSGM1YkhGa1FucGhOVzFsVUZOM016RlRWbkIyV0hWaGJHOXpURXAxVUhsdU1YSmlNR3RMT0doV1ZHdFdlakJGV25WV1JWa3JWVGx4Tmt4UlRFdGhlbTR2UVVod2VYQnlhM3BMWW5ka1pIbHNiM1ZwVGtocFJXMHlOVWRpUm5GWWJUSnZhbHB6UVRsaGNtbERNMDF2U210SFRURm9RakpGV0ZVeFNEVnFOQ3M0WVUxR2JWZEpkekJJUTIwNVJEQnhiRXRHVmpOdGFuVXphbk5xV25GaVpraHRRV1JTVmtVMmVFeGhjbWh6TlVaYWRXeFBlRkZhV1RGelRrUklTVkJ0VVVnMk1UVlhUV3hMZGk5RlpIcFBjbWhMVmxad2RHSklMeTh5VVQwOUlqNEtDVHd2YVcxaFoyVStDand2YzNablBnPT0ifX0iO3M6MTI6Im9yZGVyX2NvbHVtbiI7aToxO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjUtMDUtMzEgMTQ6MTk6MjAiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjUtMDYtMDYgMDA6MDQ6MDgiO3M6MTA6ImRlbGV0ZWRfYXQiO047fXM6MTE6IgAqAG9yaWdpbmFsIjthOjE5OntzOjI6ImlkIjtpOjEwO3M6MTA6Im1vZGVsX3R5cGUiO3M6MTk6IkFwcFxNb2RlbHNcUHJvcGVydHkiO3M6ODoibW9kZWxfaWQiO2k6NjtzOjQ6InV1aWQiO3M6MzY6IjBkMjU0NDgxLWFlNzYtNDExMC1iZDNhLTQwMjBhNzJmZTNhNyI7czoxNToiY29sbGVjdGlvbl9uYW1lIjtzOjE0OiJwcm9wZXJ0eV9pbWFnZSI7czo0OiJuYW1lIjtzOjM2OiI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTAiO3M6OToiZmlsZV9uYW1lIjtzOjQwOiI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTAuanBnIjtzOjk6Im1pbWVfdHlwZSI7czoxMDoiaW1hZ2UvanBlZyI7czo0OiJkaXNrIjtzOjY6InB1YmxpYyI7czoxNjoiY29udmVyc2lvbnNfZGlzayI7czo2OiJwdWJsaWMiO3M6NDoic2l6ZSI7aToyNDU1OTU7czoxMzoibWFuaXB1bGF0aW9ucyI7czoyOiJbXSI7czoxNzoiY3VzdG9tX3Byb3BlcnRpZXMiO3M6MjoiW10iO3M6MjE6ImdlbmVyYXRlZF9jb252ZXJzaW9ucyI7czoxNDoieyJ0aHVtYiI6dHJ1ZX0iO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjU0Mzg6InsidGh1bWIiOnsidXJscyI6WyI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX190aHVtYl8yNzBfMzYwLmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX3RodW1iXzIyNV8zMDAuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fdGh1bWJfMTg5XzI1Mi5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX190aHVtYl8xNThfMjExLmpwZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdNamN3SURNMk1DSStDZ2s4YVcxaFoyVWdkMmxrZEdnOUlqSTNNQ0lnYUdWcFoyaDBQU0l6TmpBaUlIaHNhVzVyT21oeVpXWTlJbVJoZEdFNmFXMWhaMlV2YW5CbFp6dGlZWE5sTmpRc0x6bHFMelJCUVZGVGExcEtVbWRCUWtGUlJVRlpRVUpuUVVGRUx5OW5RU3RSTVVwR1VWWlNVRlZxYjJkYU1sRjBZVzVDYkZwNVFqSk5VelIzU1VOb01XTXliSFZhZVVKS1UydGpaMU5zUWtaU2VVSXlUMFJCY0V4RFFtdGFWMXBvWkZkNE1FbElSakZaVjNod1pFaHJTeTg1YzBGUmQwRkpRbWRaU0VKblZVbENkMk5JUTFGclNVTm5kMVZFVVhkTVEzZDNXa1ZvVFZCR1FqQmhTSGcwWkVkb2QyTkpRMUYxU25sQmFVeERUV05JUTJjelMxTjNkMDFVVVRCT1FqaHVUMVF3TkUxcWQzVk5lbEY1THpselFWRjNSVXBEVVd0TlEzZDNXVVJSTUZsTmFVVmpTVlJKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hrdk9FRkJSVkZuUVV0M1FXZEJkMFZwUVVGSlVrRlJUVkpCWmk5RlFVSTRRVUZCUlVaQlVVVkNRVkZGUWtGQlFVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlJRVUZKUWtGM1RVTkNRVTFHUWxGUlJVRkJRVUptVVVWRFFYZEJSVVZSVlZOSlZFWkNRbWhPVWxsUlkybGpVbEY1WjFwSGFFTkRUa056WTBWV1ZYUklkMHBFVG1samIwbEtRMmhaV0VkQ2EyRktVMWx1UzBOcmNVNUVWVEpPZW1jMVQydE9SVkpWV2toVFJXeExWVEZTVmxac1pGbFhWbkJxV2tkV2JWb3lhSEJoYms0d1pGaGFNMlZJYkRabk5GTkdhRzlsU1dsWmNWTnJOVk5XYkhCbFdXMWFjV2x2TmxOc2NIRmxiM0ZoY1hsek4xTXhkSEpsTkhWaWNrTjNPRlJHZUhObVNYbGpjbE13T1ZSV01YUm1XVEprY21nMGRWQnJOV1ZpYmpaUGJuRTRaa3g2T1ZCWU1qa3ZhalVyZGk5RlFVSTRRa0ZCVFVKQlVVVkNRVkZGUWtGUlJVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlNRVUZKUWtGblVVVkJkMUZJUWxGUlJVRkJSVU5rZDBGQ1FXZE5Va0pCVldoTlVWbFRVVlpGU0ZsWVJWUkpha3RDUTBKU1EydGhSM2gzVVd0cVRURk1kMFpYU25rd1VXOVhTa1JVYUVwbVJWaEhRbXRoU21samIwdFRiekZPYW1NMFQxUndSRkpGVmtkU01HaEtVMnhPVlZaV1dsaFhSbXhoV1RKU2JGcHRaRzloVjNCNlpFaFdNbVF6YURWbGIwdEVhRWxYUjJnMGFVcHBjRXRVYkVwWFYydzFhVnB0Y1V0cWNFdFhiWEEyYVhCeGNrdDZkRXhYTW5RM2FUVjFjMHhFZUUxWVIzZzRha3A1ZEV4VU1VNVlWekU1YWxveWRVeHFOVTlZYlRVcmFuQTJka3g2T1ZCWU1qa3ZhalVyZGk5aFFVRjNSRUZSUVVORlVVMVNRVVE0UVRoWkwzTlBLemRTUjJjMlVHVktlVmxxSzFabGIzaFNjblI2ZEVaYU1TOVBjMUpRZVVSR1QyaEdWbGx4VkZwck9GSlVOWFZYUjNBMU4wNXdjM2x4VFVsak1HdE9jRTVITWxkcFdTOW9XR0pYYzJ0Rk9ETjZTMHN6TjJFemMyNVlRbXBWTDJoWGEzTktXR2hNYkdFd1RsWldjRk15WlhCR1VHUndSbUZzYkRZeGVUbDZjVVJVVkZsUVNYSndZblpVWkRseE9IRjJaMWx5YkVSRlNUVlVhMW8xY25ZMFpua3hUMmMxZEdONlVFbHdOR0kyY0Vzd2JuSXpUbE13VjBack0wZzFWRFl4ZERaVFJtVlZjWEI1U3pVck0ycE9lVzlxU0hsdWRGaFNZVVJhVkZkakx6ZDNOVUp5YTNwSFluZHNaSGxzYjNWcFRraHBSVzB5TlVkYVJuRlliVEp2YWxwelJIWldXVkZYTld4Q1RXZDRiWE5PV0dKNUszQnhTWGxRYWpkNGIzZFhXbGxxUkZGalMySXdXalpPVTJ4RGNUZDZWM2d6YW5neVVuTXhUblpxZWtGUGIzRnRaRmxzZEZaQllrOVNWMWh3VkhOVlIxZE9Za3BvYW10SWVtOUVPV0U0Y2tkVWJGZ3ZhVTgxUmxoRFZYRnlWR0V5VUM5YUlqNEtDVHd2YVcxaFoyVStDand2YzNablBnPT0ifSwibWVkaWFfbGlicmFyeV9vcmlnaW5hbCI6eyJ1cmxzIjpbIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfOTYwXzEyODAuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF84MDNfMTA3MS5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzY3Ml84OTYuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF81NjJfNzQ5LmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNDcwXzYyNy5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzM5M181MjQuanBnIiwiNjRjNDZmYjYtYTM1OC00MzllLTljMTctMzQzZDA4ODA4MjkwX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8zMjlfNDM5LmpwZyIsIjY0YzQ2ZmI2LWEzNTgtNDM5ZS05YzE3LTM0M2QwODgwODI5MF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMjc1XzM2Ny5qcGciLCI2NGM0NmZiNi1hMzU4LTQzOWUtOWMxNy0zNDNkMDg4MDgyOTBfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzIzMF8zMDcuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ09UWXdJREV5T0RBaVBnb0pQR2x0WVdkbElIZHBaSFJvUFNJNU5qQWlJR2hsYVdkb2REMGlNVEk0TUNJZ2VHeHBibXM2YUhKbFpqMGlaR0YwWVRwcGJXRm5aUzlxY0dWbk8ySmhjMlUyTkN3dk9Xb3ZORUZCVVZOcldrcFNaMEZDUVZGRlFWbEJRbWRCUVVRdkwyZEJLMUV4U2taUlZsSlFWV3B2WjFveVVYUmhia0pzV25sQ01rMVROSGRKUTJneFl6SnNkVnA1UWtwVGEyTm5VMnhDUmxKNVFqSlBSRUZ3VEVOQ2ExcFhXbWhrVjNnd1NVaEdNVmxYZUhCa1NHdExMemx6UVZGM1FVbENaMWxJUW1kVlNVSjNZMGhEVVd0SlEyZDNWVVJSZDB4RGQzZGFSV2hOVUVaQ01HRkllRFJrUjJoM1kwbERVWFZLZVVGcFRFTk5ZMGhEWnpOTFUzZDNUVlJSTUU1Q09HNVBWREEwVFdwM2RVMTZVWGt2T1hOQlVYZEZTa05SYTAxRGQzZFpSRkV3V1UxcFJXTkpWRWw1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVM4NFFVRkZVV2RCUzNkQlowRjNSV2xCUVVsU1FWRk5Va0ZtTDBWQlFqaEJRVUZGUmtGUlJVSkJVVVZDUVVGQlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWRkJRVWxDUVhkTlEwSkJUVVpDVVZGRlFVRkJRbVpSUlVOQmQwRkZSVkZWVTBsVVJrSkNhRTVTV1ZGamFXTlNVWGxuV2tkb1EwTk9RM05qUlZaVmRFaDNTa1JPYVdOdlNVcERhRmxZUjBKcllVcFRXVzVMUTJ0eFRrUlZNazU2WnpWUGEwNUZVbFZhU0ZORmJFdFZNVkpXVm14a1dWZFdjR3BhUjFadFdqSm9jR0Z1VGpCa1dGb3paVWhzTm1jMFUwWm9iMlZKYVZseFUyczFVMVpzY0dWWmJWcHhhVzgyVTJ4d2NXVnZjV0Z4ZVhNM1V6RjBjbVUwZFdKeVEzYzRWRVo0YzJaSmVXTnlVekE1VkZZeGRHWlpNbVJ5YURSMVVHczFaV0p1Tms5dWNUaG1USG81VUZneU9TOXFOU3QyTDBWQlFqaENRVUZOUWtGUlJVSkJVVVZDUVZGRlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWSkJRVWxDUVdkUlJVRjNVVWhDVVZGRlFVRkZRMlIzUVVKQlowMVNRa0ZWYUUxUldWTlJWa1ZJV1ZoRlZFbHFTMEpEUWxKRGEyRkhlSGRSYTJwTk1VeDNSbGRLZVRCUmIxZEtSRlJvU21aRldFZENhMkZLYVdOdlMxTnZNVTVxWXpSUFZIQkVVa1ZXUjFJd2FFcFRiRTVWVmxaYVdGZEdiR0ZaTWxKc1dtMWtiMkZYY0hwa1NGWXlaRE5vTldWdlMwUm9TVmRIYURScFNtbHdTMVJzU2xkWGJEVnBXbTF4UzJwd1MxZHRjRFpwY0hGeVMzcDBURmN5ZERkcE5YVnpURVI0VFZoSGVEaHFTbmwwVEZReFRsaFhNVGxxV2pKMVRHbzFUMWh0TlN0cWNEWjJUSG81VUZneU9TOXFOU3QyTDJGQlFYZEVRVkZCUTBWUlRWSkJSRGhCT0ZrdmMxTXJOMUpIWnpaUVpVcDVXV29yVm1WdmQzaHlkSHAwUmxveEwwOXpVbEI1UkVaR1FtVXhhWEJPYlZSNFJsQnROVmxoYm01emRXMTZTMjkzYUhwVVdXSlRZVTV6ZEVVek5WWXlPWEpLUWxCT2FHeEdZamx5WWpKVWNtaHZNVkEwVm5CTVExbHBSWFZXY2xFeFZtRnFURm8yYTAwNU1tdFdjVk4yVjNWWWRXUlJZV0ZpUWpWR1pFeGtZVmxJZEZoc1ZqaEVSbU54V1doSVMyTnFVRTVsYUhjNWJIRmtRbnBoTlcxbFVGTjNNekZUVm5CMldIVmhiRzl6VEVwMVVIbHVNWEppTUd0TE9HaFdWR3RXZWpCRlduVldSVmtyVlRseE5reFJURXRoZW00dlFVaHdlWEJ5YTNwTFluZGtaSGxzYjNWcFRraHBSVzB5TlVkaVJuRlliVEp2YWxwelFUbGhjbWxETTAxdlNtdEhUVEZvUWpKRldGVXhTRFZxTkNzNFlVMUdiVmRKZHpCSVEyMDVSREJ4YkV0R1ZqTnRhblV6YW5OcVduRmlaa2h0UVdSU1ZrVTJlRXhoY21oek5VWmFkV3hQZUZGYVdURnpUa1JJU1ZCdFVVZzJNVFZYVFd4TGRpOUZaSHBQY21oTFZsWndk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cnlcTWVkaWFDb2xsZWN0aW9uc1xNb2RlbHNcQ29sbGVjdGlvbnNcTWVkaWFDb2xsZWN0aW9uIjo0OntzOjg6IgAqAGl0ZW1zIjthOjE6e2k6MDtPOjQ5OiJTcGF0aWVcTWVkaWFMaWJyYXJ5XE1lZGlhQ29sbGVjdGlvbnNcTW9kZWxzXE1lZGlhIjozMzp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJwZ3NxbCI7czo4OiIAKgB0YWJsZSI7czo1OiJtZWRpYSI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE5OntzOjI6ImlkIjtpOjk7czoxMDoibW9kZWxfdHlwZSI7czoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI7czo4OiJtb2RlbF9pZCI7aTo1O3M6NDoidXVpZCI7czozNjoiODNiNWJkZGUtMGQ4Yy00ZTc0LThhODctMjFmY2E0M2RkYjhkIjtzOjE1OiJjb2xsZWN0aW9uX25hbWUiO3M6MTQ6InByb3BlcnR5X2ltYWdlIjtzOjQ6Im5hbWUiO3M6MzY6IjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNCI7czo5OiJmaWxlX25hbWUiO3M6NDA6IjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNC5qcGciO3M6OToibWltZV90eXBlIjtzOjEwOiJpbWFnZS9qcGVnIjtzOjQ6ImRpc2siO3M6NjoicHVibGljIjtzOjE2OiJjb252ZXJzaW9uc19kaXNrIjtzOjY6InB1YmxpYyI7czo0OiJzaXplIjtpOjE1MDU1MztzOjEzOiJtYW5pcHVsYXRpb25zIjtzOjI6IltdIjtzOjE3OiJjdXN0b21fcHJvcGVydGllcyI7czoyOiJbXSI7czoyMToiZ2VuZXJhdGVkX2NvbnZlcnNpb25zIjtzOjE0OiJ7InRodW1iIjp0cnVlfSI7czoxNzoicmVzcG9uc2l2ZV9pbWFnZXMiO3M6NDkzNDoieyJ0aHVtYiI6eyJ1cmxzIjpbIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX3RodW1iXzQ4MF8zNjAuanBnIiwiMmQ5YWZmMjQtYjk2Mi00MWVlLWJkZTItNDY0OTVkM2UwMGE0X19fdGh1bWJfNDAxXzMwMS5qcGciLCIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX190aHVtYl8zMzZfMjUyLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX3RodW1iXzI4MV8yMTEuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ05EZ3dJRE0yTUNJK0NnazhhVzFoWjJVZ2QybGtkR2c5SWpRNE1DSWdhR1ZwWjJoMFBTSXpOakFpSUhoc2FXNXJPbWh5WldZOUltUmhkR0U2YVcxaFoyVXZhbkJsWnp0aVlYTmxOalFzTHpscUx6UkJRVkZUYTFwS1VtZEJRa0ZSUlVGWlFVSm5RVUZFTHk5blFTdFJNVXBHVVZaU1VGVnFiMmRhTWxGMFlXNUNiRnA1UWpKTlV6UjNTVU5vTVdNeWJIVmFlVUpLVTJ0aloxTnNRa1pTZVVJeVQwUkJjRXhEUW10YVYxcG9aRmQ0TUVsSVJqRlpWM2h3WkVoclN5ODVjMEZSZDBGSlFtZFpTRUpuVlVsQ2QyTklRMUZyU1VObmQxVkVVWGRNUTNkM1drVm9UVkJHUWpCaFNIZzBaRWRvZDJOSlExRjFTbmxCYVV4RFRXTklRMmN6UzFOM2QwMVVVVEJPUWpodVQxUXdORTFxZDNWTmVsRjVMemx6UVZGM1JVcERVV3ROUTNkM1dVUlJNRmxOYVVWalNWUkplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGt2T0VGQlJWRm5RVWRCUVdkQmQwVnBRVUZKVWtGUlRWSkJaaTlGUVVJNFFVRkJSVVpCVVVWQ1FWRkZRa0ZCUVVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWUlFVRkpRa0YzVFVOQ1FVMUdRbEZSUlVGQlFVSm1VVVZEUVhkQlJVVlJWVk5KVkVaQ1FtaE9VbGxSWTJsalVsRjVaMXBIYUVORFRrTnpZMFZXVlhSSWQwcEVUbWxqYjBsS1EyaFpXRWRDYTJGS1UxbHVTME5yY1U1RVZUSk9lbWMxVDJ0T1JWSlZXa2hUUld4TFZURlNWbFpzWkZsWFZuQnFXa2RXYlZveWFIQmhiazR3WkZoYU0yVkliRFpuTkZOR2FHOWxTV2xaY1ZOck5WTldiSEJsV1cxYWNXbHZObE5zY0hGbGIzRmhjWGx6TjFNeGRISmxOSFZpY2tOM09GUkdlSE5tU1hsamNsTXdPVlJXTVhSbVdUSmtjbWcwZFZCck5XVmlialpQYm5FNFpreDZPVkJZTWprdmFqVXJkaTlGUVVJNFFrRkJUVUpCVVVWQ1FWRkZRa0ZSUlVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWU1FVRkpRa0ZuVVVWQmQxRklRbEZSUlVGQlJVTmtkMEZDUVdkTlVrSkJWV2hOVVZsVFVWWkZTRmxZUlZSSmFrdENRMEpTUTJ0aFIzaDNVV3RxVFRGTWQwWlhTbmt3VVc5WFNrUlVhRXBtUlZoSFFtdGhTbWxqYjB0VGJ6Rk9hbU0wVDFSd1JGSkZWa2RTTUdoS1UyeE9WVlpXV2xoWFJteGhXVEpTYkZwdFpHOWhWM0I2WkVoV01tUXphRFZsYjB0RWFFbFhSMmcwYVVwcGNFdFViRXBYVjJ3MWFWcHRjVXRxY0V0WGJYQTJhWEJ4Y2t0NmRFeFhNblEzYVRWMWMweEVlRTFZUjNnNGFrcDVkRXhVTVU1WVZ6RTVhbG95ZFV4cU5VOVliVFVyYW5BMmRreDZPVkJZTWprdmFqVXJkaTloUVVGM1JFRlJRVU5GVVUxU1FVUTRRVFpITldVeE1XbDZhMnBxWW5GUGJHTkNVRzlqZEhKT1NVNXVlV2M0UjNWcGFGTllWREZyZFZBM2IzcHBjMFJXVUVaamJIaGhVMG8xVnpGMWJXTldlaTlCUWpac0wwUnZWVWs1VG10bFptVjNlbGR5U0RSbFV6ZDNTRmxXVlRCWVZrcFVZV0pZYUV3NE9XTldjbUV6Wm5neUsya3JXbUphVTJKMlZ6TnpLMkpXYzJwdU5XVm9jR0ZJWWpOSGNHOWFOMjVwU1RseE1HSnlkMnhhTm1waGMydE5VVloyVjJscGJGSlRkbGxrV0ZKRlQyNWxSeTkzUTNnd1RXSkJUVkJsY1ZCcFlVTXhXRlJJU21wQlRrWkdXVlJyTkRGeVNUQlRWSEEyYmk4eVVUMDlJajRLQ1R3dmFXMWhaMlUrQ2p3dmMzWm5QZz09In0sIm1lZGlhX2xpYnJhcnlfb3JpZ2luYWwiOnsidXJscyI6WyIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzEyODBfOTYwLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMTA3MF84MDMuanBnIiwiMmQ5YWZmMjQtYjk2Mi00MWVlLWJkZTItNDY0OTVkM2UwMGE0X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF84OTVfNjcxLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNzQ5XzU2Mi5qcGciLCIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzYyN180NzAuanBnIiwiMmQ5YWZmMjQtYjk2Mi00MWVlLWJkZTItNDY0OTVkM2UwMGE0X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF81MjRfMzkzLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNDM5XzMyOS5qcGciLCIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzM2N18yNzUuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ01USTRNQ0E1TmpBaVBnb0pQR2x0WVdkbElIZHBaSFJvUFNJeE1qZ3dJaUJvWldsbmFIUTlJamsyTUNJZ2VHeHBibXM2YUhKbFpqMGlaR0YwWVRwcGJXRm5aUzlxY0dWbk8ySmhjMlUyTkN3dk9Xb3ZORUZCVVZOcldrcFNaMEZDUVZGRlFWbEJRbWRCUVVRdkwyZEJLMUV4U2taUlZsSlFWV3B2WjFveVVYUmhia0pzV25sQ01rMVROSGRKUTJneFl6SnNkVnA1UWtwVGEyTm5VMnhDUmxKNVFqSlBSRUZ3VEVOQ2ExcFhXbWhrVjNnd1NVaEdNVmxYZUhCa1NHdExMemx6UVZGM1FVbENaMWxJUW1kVlNVSjNZMGhEVVd0SlEyZDNWVVJSZDB4RGQzZGFSV2hOVUVaQ01HRkllRFJrUjJoM1kwbERVWFZLZVVGcFRFTk5ZMGhEWnpOTFUzZDNUVlJSTUU1Q09HNVBWREEwVFdwM2RVMTZVWGt2T1hOQlVYZEZTa05SYTAxRGQzZFpSRkV3V1UxcFJXTkpWRWw1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVM4NFFVRkZVV2RCUjBGQlowRjNSV2xCUVVsU1FWRk5Va0ZtTDBWQlFqaEJRVUZGUmtGUlJVSkJVVVZDUVVGQlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWRkJRVWxDUVhkTlEwSkJUVVpDVVZGRlFVRkJRbVpSUlVOQmQwRkZSVkZWVTBsVVJrSkNhRTVTV1ZGamFXTlNVWGxuV2tkb1EwTk9RM05qUlZaVmRFaDNTa1JPYVdOdlNVcERhRmxZUjBKcllVcFRXVzVMUTJ0eFRrUlZNazU2WnpWUGEwNUZVbFZhU0ZORmJFdFZNVkpXVm14a1dWZFdjR3BhUjFadFdqSm9jR0Z1VGpCa1dGb3paVWhzTm1jMFUwWm9iMlZKYVZseFUyczFVMVpzY0dWWmJWcHhhVzgyVTJ4d2NXVnZjV0Z4ZVhNM1V6RjBjbVUwZFdKeVEzYzRWRVo0YzJaSmVXTnlVekE1VkZZeGRHWlpNbVJ5YURSMVVHczFaV0p1Tms5dWNUaG1USG81VUZneU9TOXFOU3QyTDBWQlFqaENRVUZOUWtGUlJVSkJVVVZDUVZGRlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWSkJRVWxDUVdkUlJVRjNVVWhDVVZGRlFVRkZRMlIzUVVKQlowMVNRa0ZWYUUxUldWTlJWa1ZJV1ZoRlZFbHFTMEpEUWxKRGEyRkhlSGRSYTJwTk1VeDNSbGRLZVRCUmIxZEtSRlJvU21aRldFZENhMkZLYVdOdlMxTnZNVTVxWXpSUFZIQkVVa1ZXUjFJd2FFcFRiRTVWVmxaYVdGZEdiR0ZaTWxKc1dtMWtiMkZYY0hwa1NGWXlaRE5vTldWdlMwUm9TVmRIYURScFNtbHdTMVJzU2xkWGJEVnBXbTF4UzJwd1MxZHRjRFpwY0hGeVMzcDBURmN5ZERkcE5YVnpURVI0VFZoSGVEaHFTbmwwVEZReFRsaFhNVGxxV2pKMVRHbzFUMWh0TlN0cWNEWjJUSG81VUZneU9TOXFOU3QyTDJGQlFYZEVRVkZCUTBWUlRWSkJSRGhCTmtjMVpURXhhWHByYW1wWlkycHdXRUY2TmtoTVlYcFRaa2xrYjFCQ2NtOVpWV3d3T1ZwTWFpczJUVFJ5UVRGVWVGcE1ZMWR6YVdWV2RHSndia1pqTDNnMmJDOUViMVZaT1U1clpXWmxkM3BYY0VnMFpWTTNkMGhaVmxRd1dGWktWM1JPY25kc09HNXJOSEpZTVhVdmFYUTVSamg1TW5sck1XSmxlVFYwVjNsbFptdzJSMnh2Vm5SallXMW9iblYxU1dveWNsTjFka05PYm5GT2NYbFJlR2hYT1dOVlZWVnhTMVkzUWxZd1VrSndkbWh5SzNnd1RXSkJUVkJqVmxJNFZIZFhjVFpoZUUxWlFtOXZja05qYmtkMFdrZHBVMlJRVlM4dldpSStDZ2s4TDJsdFlXZGxQZ284TDNOMlp6ND0ifX0iO3M6MTI6Im9yZGVyX2NvbHVtbiI7aToxO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjUtMDUtMzEgMTQ6MDk6MTEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjUtMDYtMDYgMDA6MDQ6MDciO3M6MTA6ImRlbGV0ZWRfYXQiO047fXM6MTE6IgAqAG9yaWdpbmFsIjthOjE5OntzOjI6ImlkIjtpOjk7czoxMDoibW9kZWxfdHlwZSI7czoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI7czo4OiJtb2RlbF9pZCI7aTo1O3M6NDoidXVpZCI7czozNjoiODNiNWJkZGUtMGQ4Yy00ZTc0LThhODctMjFmY2E0M2RkYjhkIjtzOjE1OiJjb2xsZWN0aW9uX25hbWUiO3M6MTQ6InByb3BlcnR5X2ltYWdlIjtzOjQ6Im5hbWUiO3M6MzY6IjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNCI7czo5OiJmaWxlX25hbWUiO3M6NDA6IjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNC5qcGciO3M6OToibWltZV90eXBlIjtzOjEwOiJpbWFnZS9qcGVnIjtzOjQ6ImRpc2siO3M6NjoicHVibGljIjtzOjE2OiJjb252ZXJzaW9uc19kaXNrIjtzOjY6InB1YmxpYyI7czo0OiJzaXplIjtpOjE1MDU1MztzOjEzOiJtYW5pcHVsYXRpb25zIjtzOjI6IltdIjtzOjE3OiJjdXN0b21fcHJvcGVydGllcyI7czoyOiJbXSI7czoyMToiZ2VuZXJhdGVkX2NvbnZlcnNpb25zIjtzOjE0OiJ7InRodW1iIjp0cnVlfSI7czoxNzoicmVzcG9uc2l2ZV9pbWFnZXMiO3M6NDkzNDoieyJ0aHVtYiI6eyJ1cmxzIjpbIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX3RodW1iXzQ4MF8zNjAuanBnIiwiMmQ5YWZmMjQtYjk2Mi00MWVlLWJkZTItNDY0OTVkM2UwMGE0X19fdGh1bWJfNDAxXzMwMS5qcGciLCIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX190aHVtYl8zMzZfMjUyLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX3RodW1iXzI4MV8yMTEuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ05EZ3dJRE0yTUNJK0NnazhhVzFoWjJVZ2QybGtkR2c5SWpRNE1DSWdhR1ZwWjJoMFBTSXpOakFpSUhoc2FXNXJPbWh5WldZOUltUmhkR0U2YVcxaFoyVXZhbkJsWnp0aVlYTmxOalFzTHpscUx6UkJRVkZUYTFwS1VtZEJRa0ZSUlVGWlFVSm5RVUZFTHk5blFTdFJNVXBHVVZaU1VGVnFiMmRhTWxGMFlXNUNiRnA1UWpKTlV6UjNTVU5vTVdNeWJIVmFlVUpLVTJ0aloxTnNRa1pTZVVJeVQwUkJjRXhEUW10YVYxcG9aRmQ0TUVsSVJqRlpWM2h3WkVoclN5ODVjMEZSZDBGSlFtZFpTRUpuVlVsQ2QyTklRMUZyU1VObmQxVkVVWGRNUTNkM1drVm9UVkJHUWpCaFNIZzBaRWRvZDJOSlExRjFTbmxCYVV4RFRXTklRMmN6UzFOM2QwMVVVVEJPUWpodVQxUXdORTFxZDNWTmVsRjVMemx6UVZGM1JVcERVV3ROUTNkM1dVUlJNRmxOYVVWalNWUkplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGt2T0VGQlJWRm5RVWRCUVdkQmQwVnBRVUZKVWtGUlRWSkJaaTlGUVVJNFFVRkJSVVpCVVVWQ1FWRkZRa0ZCUVVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWUlFVRkpRa0YzVFVOQ1FVMUdRbEZSUlVGQlFVSm1VVVZEUVhkQlJVVlJWVk5KVkVaQ1FtaE9VbGxSWTJsalVsRjVaMXBIYUVORFRrTnpZMFZXVlhSSWQwcEVUbWxqYjBsS1EyaFpXRWRDYTJGS1UxbHVTME5yY1U1RVZUSk9lbWMxVDJ0T1JWSlZXa2hUUld4TFZURlNWbFpzWkZsWFZuQnFXa2RXYlZveWFIQmhiazR3WkZoYU0yVkliRFpuTkZOR2FHOWxTV2xaY1ZOck5WTldiSEJsV1cxYWNXbHZObE5zY0hGbGIzRmhjWGx6TjFNeGRISmxOSFZpY2tOM09GUkdlSE5tU1hsamNsTXdPVlJXTVhSbVdUSmtjbWcwZFZCck5XVmlialpQYm5FNFpreDZPVkJZTWprdmFqVXJkaTlGUVVJNFFrRkJUVUpCVVVWQ1FWRkZRa0ZSUlVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWU1FVRkpRa0ZuVVVWQmQxRklRbEZSUlVGQlJVTmtkMEZDUVdkTlVrSkJWV2hOVVZsVFVWWkZTRmxZUlZSSmFrdENRMEpTUTJ0aFIzaDNVV3RxVFRGTWQwWlhTbmt3VVc5WFNrUlVhRXBtUlZoSFFtdGhTbWxqYjB0VGJ6Rk9hbU0wVDFSd1JGSkZWa2RTTUdoS1UyeE9WVlpXV2xoWFJteGhXVEpTYkZwdFpHOWhWM0I2WkVoV01tUXphRFZsYjB0RWFFbFhSMmcwYVVwcGNFdFViRXBYVjJ3MWFWcHRjVXRxY0V0WGJYQTJhWEJ4Y2t0NmRFeFhNblEzYVRWMWMweEVlRTFZUjNnNGFrcDVkRXhVTVU1WVZ6RTVhbG95ZFV4cU5VOVliVFVyYW5BMmRreDZPVkJZTWprdmFqVXJkaTloUVVGM1JFRlJRVU5GVVUxU1FVUTRRVFpITldVeE1XbDZhMnBxWW5GUGJHTkNVRzlqZEhKT1NVNXVlV2M0UjNWcGFGTllWREZyZFZBM2IzcHBjMFJXVUVaamJIaGhVMG8xVnpGMWJXTldlaTlCUWpac0wwUnZWVWs1VG10bFptVjNlbGR5U0RSbFV6ZDNTRmxXVlRCWVZrcFVZV0pZYUV3NE9XTldjbUV6Wm5neUsya3JXbUphVTJKMlZ6TnpLMkpXYzJwdU5XVm9jR0ZJWWpOSGNHOWFOMjVwU1RseE1HSnlkMnhhTm1waGMydE5VVloyVjJscGJGSlRkbGxrV0ZKRlQyNWxSeTkzUTNnd1RXSkJUVkJsY1ZCcFlVTXhXRlJJU21wQlRrWkdXVlJyTkRGeVNUQlRWSEEyYmk4eVVUMDlJajRLQ1R3dmFXMWhaMlUrQ2p3dmMzWm5QZz09In0sIm1lZGlhX2xpYnJhcnlfb3JpZ2luYWwiOnsidXJscyI6WyIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzEyODBfOTYwLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMTA3MF84MDMuanBnIiwiMmQ5YWZmMjQtYjk2Mi00MWVlLWJkZTItNDY0OTVkM2UwMGE0X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF84OTVfNjcxLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNzQ5XzU2Mi5qcGciLCIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzYyN180NzAuanBnIiwiMmQ5YWZmMjQtYjk2Mi00MWVlLWJkZTItNDY0OTVkM2UwMGE0X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF81MjRfMzkzLmpwZyIsIjJkOWFmZjI0LWI5NjItNDFlZS1iZGUyLTQ2NDk1ZDNlMDBhNF9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNDM5XzMyOS5qcGciLCIyZDlhZmYyNC1iOTYyLTQxZWUtYmRlMi00NjQ5NWQzZTAwYTRfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzM2N18yNzUuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ01USTRNQ0E1TmpBaVBnb0pQR2x0WVdkbElIZHBaSFJvUFNJeE1qZ3dJaUJvWldsbmFIUTlJamsyTUNJZ2VHeHBibXM2YUhKbFpqMGlaR0YwWVRwcGJXRm5aUzlxY0dWbk8ySmhjMlUyTkN3dk9Xb3ZORUZCVVZOcldrcFNaMEZDUVZGRlFWbEJRbWRCUVVRdkwyZEJLMUV4U2taUlZsSlFWV3B2WjFveVVYUmhia0pzV25sQ01rMVROSGRKUTJneFl6SnNkVnA1UWtwVGEyTm5VMnhDUmxKNVFqSlBSRUZ3VEVOQ2ExcFhXbWhrVjNnd1NVaEdNVmxYZUhCa1NHdExMemx6UVZGM1FVbENaMWxJUW1kVlNVSjNZMGhEVVd0SlEyZDNWVVJSZDB4RGQzZGFSV2hOVUVaQ01HRkllRFJrUjJoM1kwbERVWFZLZVVGcFRFTk5ZMGhEWnpOTFUzZDNUVlJSTUU1Q09HNVBWREEwVFdwM2RVMTZVWGt2T1hOQlVYZEZTa05SYTAxRGQzZFpSRkV3V1UxcFJXTkpWRWw1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVM4NFFVRkZVV2RCUjBGQlowRjNSV2xCUVVsU1FWRk5Va0ZtTDBWQlFqaEJRVUZGUmtGUlJVSkJVVVZDUVVGQlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWRkJRVWxDUVhkTlEwSkJUVVpDVVZGRlFVRkJRbVpSUlVOQmQwRkZSVkZWVTBsVVJrSkNhRTVTV1ZGamFXTlNVWGxuV2tkb1EwTk9RM05qUlZaVmRFaDNTa1JPYVdOdlNVcERhRmxZUjBKcllVcFRXVzVMUTJ0eFRrUlZNazU2WnpWUGEwNUZVbFZhU0ZORmJFdFZNVkpXVm14a1dWZFdjR3BhUjFadFdqSm9jR0Z1VGpCa1dGb3paVWhzTm1jMFUwWm9iMlZKYVZseFUyczFVMVpzY0dWWmJWcHhhVzgyVTJ4d2NXVnZjV0Z4ZVhNM1V6RjBjbVUwZFdKeVEzYzRWRVo0YzJaSmVXTnlVekE1VkZZeGRHWlpNbVJ5YURSMVVHczFaV0p1Tms5dWNUaG1USG81VUZneU9TOXFOU3QyTDBWQlFqaENRVUZOUWtGUlJVSkJVVVZDUVZGRlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWSkJRVWxDUVdkUlJVRjNVVWhDVVZGRlFVRkZRMlIzUVVKQlowMVNRa0ZWYUUxUldWTlJWa1ZJV1ZoRlZFbHFTMEpEUWxKRGEyRkhlSGRSYTJwTk1VeDNSbGRLZVRCUmIxZEtSRlJvU21aRldFZENhMkZLYVdOdlMxTnZNVTVxWXpSUFZIQkVVa1ZXUjFJd2FFcFRiRTVWVmxaYVdGZEdiR0ZaTWxKc1dtMWtiMkZYY0hwa1NGWXlaRE5vTldWdlMwUm9TVmRIYURScFNtbHdTMVJzU2xkWGJEVnBXbTF4UzJwd1MxZHRjRFpwY0hGeVMzcDBURmN5ZERkcE5YVnpURVI0VFZoSGVEaHFTbmwwVEZReFRsaFhNVGxxV2pKMVRHbzFUMWh0TlN0cWNEWjJUSG81VUZneU9TOXFOU3QyTDJGQlFYZEVRVkZCUTBWUlRWSkJSRGhCTmtjMVpURXhhWHByYW1wWlkycHdXRUY2TmtoTVlYcFRaa2xrYjFCQ2NtOVpWV3d3T1ZwTWFpczJUVFJ5UVRGVWVGcE1ZMWR6YVdWV2RHSndia1pqTDNnMmJDOUViMVZaT1U1clpXWmxkM3BYY0VnMFpWTTNkMGhaVmxRd1dGWktWM1JPY25kc09HNXJOSEpZTVhVdmFYUTVSamg1TW5sck1XSmxlVFYwVjNsbFptdzJSMnh2Vm5SallXMW9iblYxU1dveWNsTjFka05PYm5GT2NYbFJlR2hYT1dOVlZWVnhTMVkzUWxZd1VrSndkbWh5SzNnd1RXSkJUVkJqVmxJNFZIZFhjVFpoZUUxWlFtOXZja05qYmtkMFdrZHBVMlJRVlM4dldpSStDZ2s4TDJsdFlXZGxQZ284TDNOMlp6ND0ifX0iO3M6MTI6Im9yZGVyX2NvbHVtbiI7aToxO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjUtMDUtMzEgMTQ6MDk6MTEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjUtMDYtMDYgMDA6MDQ6MDciO3M6MTA6ImRlbGV0ZWRfYXQiO047fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6NDp7czoxMzoibWFuaXB1bGF0aW9ucyI7czo1OiJhcnJheSI7czoxNzoiY3VzdG9tX3Byb3BlcnRpZXMiO3M6NToiYXJyYXkiO3M6MjE6ImdlbmVyYXRlZF9jb252ZXJzaW9ucyI7czo1OiJhcnJheSI7czoxNzoicmVzcG9uc2l2ZV9pbWFnZXMiO3M6NToiYXJyYXkiO31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6Mjp7aTowO3M6MTI6Im9yaWdpbmFsX3VybCI7aToxO3M6MTE6InByZXZpZXdfdXJsIjt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoyNzoiACoAcmVsYXRpb25BdXRvbG9hZENhbGxiYWNrIjtOO3M6MjY6IgAqAHJlbGF0aW9uQXV0b2xvYWRDb250ZXh0IjtOO3M6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjA6e31zOjE4OiIAKgBzdHJlYW1DaHVua1NpemUiO2k6MTA0ODU3Njt9fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjE0OiJjb2xsZWN0aW9uTmFtZSI7TjtzOjEzOiJmb3JtRmllbGROYW1lIjtOO31zOjc6InNvY2lldHkiO047fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6Mjc6IgAqAHJlbGF0aW9uQXV0b2xvYWRDYWxsYmFjayI7TjtzOjI2OiIAKgByZWxhdGlvbkF1dG9sb2FkQ29udGV4dCI7TjtzOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czoxMzoidXNlc1VuaXF1ZUlkcyI7YjowO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTozMjp7aTowO3M6NzoidXNlcl9pZCI7aToxO3M6MTA6InNvY2lldHlfaWQiO2k6MjtzOjEzOiJzdWJfc2VjdG9yX2lkIjtpOjM7czo1OiJ0aXRsZSI7aTo0O3M6NDoic2x1ZyI7aTo1O3M6MTE6ImRlc2NyaXB0aW9uIjtpOjY7czo4OiJrZXl3b3JkcyI7aTo3O3M6NzoicHVycG9zZSI7aTo4O3M6MTM6InByb3BlcnR5X3R5cGUiO2k6OTtzOjk6InBsb3Rfc2l6ZSI7aToxMDtzOjE1OiJwbG90X2RpbWVuc2lvbnMiO2k6MTE7czo1OiJwcmljZSI7aToxMjtzOjQ6InJlbnQiO2k6MTM7czo5OiJyZW50X3R5cGUiO2k6MTQ7czo3OiJwbG90X25vIjtpOjE1O3M6Njoic3RyZWV0IjtpOjE2O3M6ODoibG9jYXRpb24iO2k6MTc7czo4OiJsYXRpdHVkZSI7aToxODtzOjk6ImxvbmdpdHVkZSI7aToxOTtzOjg6ImZlYXR1cmVzIjtpOjIwO3M6MTc6Im5lYXJieV9mYWNpbGl0aWVzIjtpOjIxO3M6MTY6Imluc3RhbGxtZW50X3BsYW4iO2k6MjI7czoxMjoiYmVzdF9zZWxsaW5nIjtpOjIzO3M6MTA6InRvZGF5X2RlYWwiO2k6MjQ7czo4OiJhcHByb3ZlZCI7aToyNTtzOjY6InN0YXR1cyI7aToyNjtzOjk6Im1hcF9lbWJlZCI7aToyNztzOjExOiJ2aWRlb19lbWJlZCI7aToyODtzOjE1OiJzaG9ydF92aWRlb191cmwiO2k6Mjk7czoxMDoiZXh0cmFfZGF0YSI7aTozMDtzOjEwOiJjcmVhdGVkX2J5IjtpOjMxO3M6NToidmlld3MiO31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO31zOjE2OiIAKgBmb3JjZURlbGV0aW5nIjtiOjA7fWk6MztPOjE5OiJBcHBcTW9kZWxzXFByb3BlcnR5IjozMzp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJwZ3NxbCI7czo4OiIAKgB0YWJsZSI7czoxMDoicHJvcGVydGllcyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjEwOntzOjI6ImlkIjtpOjQ7czo1OiJ0aXRsZSI7czoyMzoiNSBtYXJsYSAgaG91c2UgZm9yIHJlbnQiO3M6NDoic2x1ZyI7czoyMjoiNS1tYXJsYS1ob3VzZS1mb3ItcmVudCI7czo1OiJwcmljZSI7aTo3MDAwMDAwMDtzOjc6InB1cnBvc2UiO3M6NDoic2FsZSI7czo4OiJsb2NhdGlvbiI7TjtzOjU6InZpZXdzIjtpOjA7czo5OiJwbG90X3NpemUiO3M6NzoiNyBNYXJsYSI7czo4OiJmZWF0dXJlcyI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI1LTA1LTMxIDE0OjA1OjA2Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTA6e3M6MjoiaWQiO2k6NDtzOjU6InRpdGxlIjtzOjIzOiI1IG1hcmxhICBob3VzZSBmb3IgcmVudCI7czo0OiJzbHVnIjtzOjIyOiI1LW1hcmxhLWhvdXNlLWZvci1yZW50IjtzOjU6InByaWNlIjtpOjcwMDAwMDAwO3M6NzoicHVycG9zZSI7czo0OiJzYWxlIjtzOjg6ImxvY2F0aW9uIjtOO3M6NToidmlld3MiO2k6MDtzOjk6InBsb3Rfc2l6ZSI7czo3OiI3IE1hcmxhIjtzOjg6ImZlYXR1cmVzIjtOO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjUtMDUtMzEgMTQ6MDU6MDYiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjk6e3M6ODoiZmVhdHVyZXMiO3M6NToiYXJyYXkiO3M6MTc6Im5lYXJieV9mYWNpbGl0aWVzIjtzOjU6ImFycmF5IjtzOjE2OiJpbnN0YWxsbWVudF9wbGFuIjtzOjU6ImFycmF5IjtzOjEyOiJiZXN0X3NlbGxpbmciO3M6NzoiYm9vbGVhbiI7czoxMDoidG9kYXlfZGVhbCI7czo3OiJib29sZWFuIjtzOjg6ImFwcHJvdmVkIjtzOjc6ImJvb2xlYW4iO3M6ODoibGF0aXR1ZGUiO3M6NToiZmxvYXQiO3M6OToibG9uZ2l0dWRlIjtzOjU6ImZsb2F0IjtzOjEwOiJkZWxldGVkX2F0IjtzOjg6ImRhdGV0aW1lIjt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjE6e2k6MDtzOjE4OiJwcm9wZXJ0eV9pbWFnZV91cmwiO31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjI6e3M6NToibWVkaWEiO086NzE6IlNwYXRpZVxNZWRpYUxpYnJhcnlcTWVkaWFDb2xsZWN0aW9uc1xNb2RlbHNcQ29sbGVjdGlvbnNcTWVkaWFDb2xsZWN0aW9uIjo0OntzOjg6IgAqAGl0ZW1zIjthOjE6e2k6MDtPOjQ5OiJTcGF0aWVcTWVkaWFMaWJyYXJ5XE1lZGlhQ29sbGVjdGlvbnNcTW9kZWxzXE1lZGlhIjozMzp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJwZ3NxbCI7czo4OiIAKgB0YWJsZSI7czo1OiJtZWRpYSI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE5OntzOjI6ImlkIjtpOjg7czoxMDoibW9kZWxfdHlwZSI7czoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI7czo4OiJtb2RlbF9pZCI7aTo0O3M6NDoidXVpZCI7czozNjoiYTAwZDc3NTYtMzFjYS00MTI5LTg1OTgtNWM4YmJjYjkxYjk1IjtzOjE1OiJjb2xsZWN0aW9uX25hbWUiO3M6MTQ6InByb3BlcnR5X2ltYWdlIjtzOjQ6Im5hbWUiO3M6MzY6IjVlZWZjYmI3LThmZmItNDJmYi04YWU5LWExYTdjZGM3YWIwYyI7czo5OiJmaWxlX25hbWUiO3M6NDA6IjVlZWZjYmI3LThmZmItNDJmYi04YWU5LWExYTdjZGM3YWIwYy5qcGciO3M6OToibWltZV90eXBlIjtzOjEwOiJpbWFnZS9qcGVnIjtzOjQ6ImRpc2siO3M6NjoicHVibGljIjtzOjE2OiJjb252ZXJzaW9uc19kaXNrIjtzOjY6InB1YmxpYyI7czo0OiJzaXplIjtpOjM5Mzc2O3M6MTM6Im1hbmlwdWxhdGlvbnMiO3M6MjoiW10iO3M6MTc6ImN1c3RvbV9wcm9wZXJ0aWVzIjtzOjI6IltdIjtzOjIxOiJnZW5lcmF0ZWRfY29udmVyc2lvbnMiO3M6MTQ6InsidGh1bWIiOnRydWV9IjtzOjE3OiJyZXNwb25zaXZlX2ltYWdlcyI7czo0NDg0OiJ7InRodW1iIjp7InVybHMiOlsiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjX19fdGh1bWJfNDgwXzM2MC5qcGciLCI1ZWVmY2JiNy04ZmZiLTQyZmItOGFlOS1hMWE3Y2RjN2FiMGNfX190aHVtYl80MDFfMzAxLmpwZyIsIjVlZWZjYmI3LThmZmItNDJmYi04YWU5LWExYTdjZGM3YWIwY19fX3RodW1iXzMzNl8yNTIuanBnIiwiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjX19fdGh1bWJfMjgxXzIxMS5qcGciXSwiYmFzZTY0c3ZnIjoiZGF0YTppbWFnZVwvc3ZnK3htbDtiYXNlNjQsUENGRVQwTlVXVkJGSUhOMlp5QlFWVUpNU1VNZ0lpMHZMMWN6UXk4dlJGUkVJRk5XUnlBeExqRXZMMFZPSWlBaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdlIzSmhjR2hwWTNNdlUxWkhMekV1TVM5RVZFUXZjM1puTVRFdVpIUmtJajRLUEhOMlp5QjJaWEp6YVc5dVBTSXhMakVpSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh5TURBd0wzTjJaeUlnZUcxc2JuTTZlR3hwYm1zOUltaDBkSEE2THk5M2QzY3Vkek11YjNKbkx6RTVPVGt2ZUd4cGJtc2lJSGh0YkRwemNHRmpaVDBpY0hKbGMyVnlkbVVpSUhnOUlqQWlDaUI1UFNJd0lpQjJhV1YzUW05NFBTSXdJREFnTkRnd0lETTJNQ0krQ2drOGFXMWhaMlVnZDJsa2RHZzlJalE0TUNJZ2FHVnBaMmgwUFNJek5qQWlJSGhzYVc1ck9taHlaV1k5SW1SaGRHRTZhVzFoWjJVdmFuQmxaenRpWVhObE5qUXNMemxxTHpSQlFWRlRhMXBLVW1kQlFrRlJSVUZaUVVKblFVRkVMeTluUVN0Uk1VcEdVVlpTVUZWcWIyZGFNbEYwWVc1Q2JGcDVRakpOVXpSM1NVTm9NV015YkhWYWVVSktVMnRqWjFOc1FrWlNlVUl5VDBSQmNFeERRbXRhVjFwb1pGZDRNRWxJUmpGWlYzaHdaRWhyU3k4NWMwRlJkMEZKUW1kWlNFSm5WVWxDZDJOSVExRnJTVU5uZDFWRVVYZE1RM2QzV2tWb1RWQkdRakJoU0hnMFpFZG9kMk5KUTFGMVNubEJhVXhEVFdOSVEyY3pTMU4zZDAxVVVUQk9Ramh1VDFRd05FMXFkM1ZOZWxGNUx6bHpRVkYzUlVwRFVXdE5RM2QzV1VSUk1GbE5hVVZqU1ZSSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYa3ZPRUZCUlZGblFVZEJRV2RCZDBWcFFVRkpVa0ZSVFZKQlppOUZRVUk0UVVGQlJVWkJVVVZDUVZGRlFrRkJRVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZSUVVGSlFrRjNUVU5DUVUxR1FsRlJSVUZCUVVKbVVVVkRRWGRCUlVWUlZWTkpWRVpDUW1oT1VsbFJZMmxqVWxGNVoxcEhhRU5EVGtOelkwVldWWFJJZDBwRVRtbGpiMGxLUTJoWldFZENhMkZLVTFsdVMwTnJjVTVFVlRKT2VtYzFUMnRPUlZKVldraFRSV3hMVlRGU1ZsWnNaRmxYVm5CcVdrZFdiVm95YUhCaGJrNHdaRmhhTTJWSWJEWm5ORk5HYUc5bFNXbFpjVk5yTlZOV2JIQmxXVzFhY1dsdk5sTnNjSEZsYjNGaGNYbHpOMU14ZEhKbE5IVmlja04zT0ZSR2VITm1TWGxqY2xNd09WUldNWFJtV1RKa2NtZzBkVkJyTldWaWJqWlBibkU0Wmt4Nk9WQllNamt2YWpVcmRpOUZRVUk0UWtGQlRVSkJVVVZDUVZGRlFrRlJSVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZTUVVGSlFrRm5VVVZCZDFGSVFsRlJSVUZCUlVOa2QwRkNRV2ROVWtKQlZXaE5VVmxUVVZaRlNGbFlSVlJKYWt0Q1EwSlNRMnRoUjNoM1VXdHFUVEZNZDBaWFNua3dVVzlYU2tSVWFFcG1SVmhIUW10aFNtbGpiMHRUYnpGT2FtTTBUMVJ3UkZKRlZrZFNNR2hLVTJ4T1ZWWldXbGhYUm14aFdUSlNiRnB0Wkc5aFYzQjZaRWhXTW1RemFEVmxiMHRFYUVsWFIyZzBhVXBwY0V0VWJFcFhWMncxYVZwdGNVdHFjRXRYYlhBMmFYQnhja3Q2ZEV4WE1uUTNhVFYxYzB4RWVFMVlSM2c0YWtwNWRFeFVNVTVZVnpFNWFsb3lkVXhxTlU5WWJUVXJhbkEyZGt4Nk9WQllNamt2YWpVcmRpOWhRVUYzUkVGUlFVTkZVVTFTUVVRNFFUUlhPR3Q0WkhoemR6WkhkVGd3WVVGWWJHZEtRakpHV21WeFlXUlpVMjlYU2tOclZtWTRUMWg1TW10WmFsVmlhMFpUTTI5S1NtMXdSRWN4Y1RWc2VHcEdWa3AwVWxNMGJVbDZhekZ2TTJReFNHTnhVV2QzVFZadFZ6QlZWbk0zVGpWbFUyRldlREkyYm0xeU5tcGpXSFIzY1hNMU5WQlRkbFZRUkdWb2FWTjRVWE5sVTB0TFMySkJNVE13VFhoVFJHRmphblpUTTA5c1RFZHRWalJPUmtaU1kxb3ZMemxyUFNJK0NnazhMMmx0WVdkbFBnbzhMM04yWno0PSJ9LCJtZWRpYV9saWJyYXJ5X29yaWdpbmFsIjp7InVybHMiOlsiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF83MjBfNTQwLmpwZyIsIjVlZWZjYmI3LThmZmItNDJmYi04YWU5LWExYTdjZGM3YWIwY19fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNjAyXzQ1Mi5qcGciLCI1ZWVmY2JiNy04ZmZiLTQyZmItOGFlOS1hMWE3Y2RjN2FiMGNfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzUwNF8zNzguanBnIiwiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF80MjFfMzE2LmpwZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdOekl3SURVME1DSStDZ2s4YVcxaFoyVWdkMmxrZEdnOUlqY3lNQ0lnYUdWcFoyaDBQU0kxTkRBaUlIaHNhVzVyT21oeVpXWTlJbVJoZEdFNmFXMWhaMlV2YW5CbFp6dGlZWE5sTmpRc0x6bHFMelJCUVZGVGExcEtVbWRCUWtGUlJVRlpRVUpuUVVGRUx5OW5RU3RSTVVwR1VWWlNVRlZxYjJkYU1sRjBZVzVDYkZwNVFqSk5VelIzU1VOb01XTXliSFZhZVVKS1UydGpaMU5zUWtaU2VVSXlUMFJCY0V4RFFtdGFWMXBvWkZkNE1FbElSakZaVjNod1pFaHJTeTg1YzBGUmQwRkpRbWRaU0VKblZVbENkMk5JUTFGclNVTm5kMVZFVVhkTVEzZDNXa1ZvVFZCR1FqQmhTSGcwWkVkb2QyTkpRMUYxU25sQmFVeERUV05JUTJjelMxTjNkMDFVVVRCT1FqaHVUMVF3TkUxcWQzVk5lbEY1THpselFWRjNSVXBEVVd0TlEzZDNXVVJSTUZsTmFVVmpTVlJKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hrdk9FRkJSVkZuUVVkQlFXZEJkMFZwUVVGSlVrRlJUVkpCWmk5RlFVSTRRVUZCUlVaQlVVVkNRVkZGUWtGQlFVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlJRVUZKUWtGM1RVTkNRVTFHUWxGUlJVRkJRVUptVVVWRFFYZEJSVVZSVlZOSlZFWkNRbWhPVWxsUlkybGpVbEY1WjFwSGFFTkRUa056WTBWV1ZYUklkMHBFVG1samIwbEtRMmhaV0VkQ2EyRktVMWx1UzBOcmNVNUVWVEpPZW1jMVQydE9SVkpWV2toVFJXeExWVEZTVmxac1pGbFhWbkJxV2tkV2JWb3lhSEJoYms0d1pGaGFNMlZJYkRabk5GTkdhRzlsU1dsWmNWTnJOVk5XYkhCbFdXMWFjV2x2TmxOc2NIRmxiM0ZoY1hsek4xTXhkSEpsTkhWaWNrTjNPRlJHZUhObVNYbGpjbE13T1ZSV01YUm1XVEprY21nMGRWQnJOV1ZpYmpaUGJuRTRaa3g2T1ZCWU1qa3ZhalVyZGk5RlFVSTRRa0ZCVFVKQlVVVkNRVkZGUWtGUlJVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlNRVUZKUWtGblVVVkJkMUZJUWxGUlJVRkJSVU5rZDBGQ1FXZE5Va0pCVldoTlVWbFRVVlpGU0ZsWVJWUkpha3RDUTBKU1EydGhSM2gzVVd0cVRURk1kMFpYU25rd1VXOVhTa1JVYUVwbVJWaEhRbXRoU21samIwdFRiekZPYW1NMFQxUndSRkpGVmtkU01HaEtVMnhPVlZaV1dsaFhSbXhoV1RKU2JGcHRaRzloVjNCNlpFaFdNbVF6YURWbGIwdEVhRWxYUjJnMGFVcHBjRXRVYkVwWFYydzFhVnB0Y1V0cWNFdFhiWEEyYVhCeGNrdDZkRXhYTW5RM2FUVjFjMHhFZUUxWVIzZzRha3A1ZEV4VU1VNVlWekU1YWxveWRVeHFOVTlZYlRVcmFuQTJka3g2T1ZCWU1qa3ZhalVyZGk5aFFVRjNSRUZSUVVORlVVMVNRVVE0UVRSWE9XdDRaSGh6ZHpaSGRUa3dWMEZZYkdkS1FqSkdXbGR4Tm1SWlUyOVhTa05yVm1ZNFQxaDVNbXRtYkhGT2VVTndZblZvU2sweFNWa3lkRmc0TTBkTlZsVnRNVUpNYVZsblNFcHlVblpNY1U4MVNIbEVRWGd3Y2sxMGIyODNaREppZVRock1VNTRNalp1YlhJMmFtTlljelp4ZW01ck9VczVVVGhPWVVkS1RFWkRlRFZKYjI5eGJVSnpVMkZIV1hCQ2RFOVNNMjkxWkV0WFRrNTVPRWRwYVc5MVRrZ3ZMekpSUFQwaVBnb0pQQzlwYldGblpUNEtQQzl6ZG1jKyJ9fSI7czoxMjoib3JkZXJfY29sdW1uIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNS0wNS0zMSAxNDowNTowNiI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNi0wNiAwMDowNDowOCI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTk6e3M6MjoiaWQiO2k6ODtzOjEwOiJtb2RlbF90eXBlIjtzOjE5OiJBcHBcTW9kZWxzXFByb3BlcnR5IjtzOjg6Im1vZGVsX2lkIjtpOjQ7czo0OiJ1dWlkIjtzOjM2OiJhMDBkNzc1Ni0zMWNhLTQxMjktODU5OC01YzhiYmNiOTFiOTUiO3M6MTU6ImNvbGxlY3Rpb25fbmFtZSI7czoxNDoicHJvcGVydHlfaW1hZ2UiO3M6NDoibmFtZSI7czozNjoiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjIjtzOjk6ImZpbGVfbmFtZSI7czo0MDoiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjLmpwZyI7czo5OiJtaW1lX3R5cGUiO3M6MTA6ImltYWdlL2pwZWciO3M6NDoiZGlzayI7czo2OiJwdWJsaWMiO3M6MTY6ImNvbnZlcnNpb25zX2Rpc2siO3M6NjoicHVibGljIjtzOjQ6InNpemUiO2k6MzkzNzY7czoxMzoibWFuaXB1bGF0aW9ucyI7czoyOiJbXSI7czoxNzoiY3VzdG9tX3Byb3BlcnRpZXMiO3M6MjoiW10iO3M6MjE6ImdlbmVyYXRlZF9jb252ZXJzaW9ucyI7czoxNDoieyJ0aHVtYiI6dHJ1ZX0iO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjQ0ODQ6InsidGh1bWIiOnsidXJscyI6WyI1ZWVmY2JiNy04ZmZiLTQyZmItOGFlOS1hMWE3Y2RjN2FiMGNfX190aHVtYl80ODBfMzYwLmpwZyIsIjVlZWZjYmI3LThmZmItNDJmYi04YWU5LWExYTdjZGM3YWIwY19fX3RodW1iXzQwMV8zMDEuanBnIiwiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjX19fdGh1bWJfMzM2XzI1Mi5qcGciLCI1ZWVmY2JiNy04ZmZiLTQyZmItOGFlOS1hMWE3Y2RjN2FiMGNfX190aHVtYl8yODFfMjExLmpwZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdORGd3SURNMk1DSStDZ2s4YVcxaFoyVWdkMmxrZEdnOUlqUTRNQ0lnYUdWcFoyaDBQU0l6TmpBaUlIaHNhVzVyT21oeVpXWTlJbVJoZEdFNmFXMWhaMlV2YW5CbFp6dGlZWE5sTmpRc0x6bHFMelJCUVZGVGExcEtVbWRCUWtGUlJVRlpRVUpuUVVGRUx5OW5RU3RSTVVwR1VWWlNVRlZxYjJkYU1sRjBZVzVDYkZwNVFqSk5VelIzU1VOb01XTXliSFZhZVVKS1UydGpaMU5zUWtaU2VVSXlUMFJCY0V4RFFtdGFWMXBvWkZkNE1FbElSakZaVjNod1pFaHJTeTg1YzBGUmQwRkpRbWRaU0VKblZVbENkMk5JUTFGclNVTm5kMVZFVVhkTVEzZDNXa1ZvVFZCR1FqQmhTSGcwWkVkb2QyTkpRMUYxU25sQmFVeERUV05JUTJjelMxTjNkMDFVVVRCT1FqaHVUMVF3TkUxcWQzVk5lbEY1THpselFWRjNSVXBEVVd0TlEzZDNXVVJSTUZsTmFVVmpTVlJKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hrdk9FRkJSVkZuUVVkQlFXZEJkMFZwUVVGSlVrRlJUVkpCWmk5RlFVSTRRVUZCUlVaQlVVVkNRVkZGUWtGQlFVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlJRVUZKUWtGM1RVTkNRVTFHUWxGUlJVRkJRVUptVVVWRFFYZEJSVVZSVlZOSlZFWkNRbWhPVWxsUlkybGpVbEY1WjFwSGFFTkRUa056WTBWV1ZYUklkMHBFVG1samIwbEtRMmhaV0VkQ2EyRktVMWx1UzBOcmNVNUVWVEpPZW1jMVQydE9SVkpWV2toVFJXeExWVEZTVmxac1pGbFhWbkJxV2tkV2JWb3lhSEJoYms0d1pGaGFNMlZJYkRabk5GTkdhRzlsU1dsWmNWTnJOVk5XYkhCbFdXMWFjV2x2TmxOc2NIRmxiM0ZoY1hsek4xTXhkSEpsTkhWaWNrTjNPRlJHZUhObVNYbGpjbE13T1ZSV01YUm1XVEprY21nMGRWQnJOV1ZpYmpaUGJuRTRaa3g2T1ZCWU1qa3ZhalVyZGk5RlFVSTRRa0ZCVFVKQlVVVkNRVkZGUWtGUlJVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlNRVUZKUWtGblVVVkJkMUZJUWxGUlJVRkJSVU5rZDBGQ1FXZE5Va0pCVldoTlVWbFRVVlpGU0ZsWVJWUkpha3RDUTBKU1EydGhSM2gzVVd0cVRURk1kMFpYU25rd1VXOVhTa1JVYUVwbVJWaEhRbXRoU21samIwdFRiekZPYW1NMFQxUndSRkpGVmtkU01HaEtVMnhPVlZaV1dsaFhSbXhoV1RKU2JGcHRaRzloVjNCNlpFaFdNbVF6YURWbGIwdEVhRWxYUjJnMGFVcHBjRXRVYkVwWFYydzFhVnB0Y1V0cWNFdFhiWEEyYVhCeGNrdDZkRXhYTW5RM2FUVjFjMHhFZUUxWVIzZzRha3A1ZEV4VU1VNVlWekU1YWxveWRVeHFOVTlZYlRVcmFuQTJka3g2T1ZCWU1qa3ZhalVyZGk5aFFVRjNSRUZSUVVORlVVMVNRVVE0UVRSWE9HdDRaSGh6ZHpaSGRUZ3dZVUZZYkdkS1FqSkdXbVZ4WVdSWlUyOVhTa05yVm1ZNFQxaDVNbXRaYWxWaWEwWlRNMjlLU20xd1JFY3hjVFZzZUdwR1ZrcDBVbE0wYlVsNmF6RnZNMlF4U0dOeFVXZDNUVlp0VnpCVlZuTTNUalZsVTJGV2VESTJibTF5Tm1waldIUjNjWE0xTlZCVGRsVlFSR1ZvYVZONFVYTmxVMHRMUzJKQk1UTXdUWGhUUkdGamFuWlRNMDlzVEVkdFZqUk9Sa1pTWTFvdkx6bHJQU0krQ2drOEwybHRZV2RsUGdvOEwzTjJaejQ9In0sIm1lZGlhX2xpYnJhcnlfb3JpZ2luYWwiOnsidXJscyI6WyI1ZWVmY2JiNy04ZmZiLTQyZmItOGFlOS1hMWE3Y2RjN2FiMGNfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzcyMF81NDAuanBnIiwiNWVlZmNiYjctOGZmYi00MmZiLThhZTktYTFhN2NkYzdhYjBjX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF82MDJfNDUyLmpwZyIsIjVlZWZjYmI3LThmZmItNDJmYi04YWU5LWExYTdjZGM3YWIwY19fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNTA0XzM3OC5qcGciLCI1ZWVmY2JiNy04ZmZiLTQyZmItOGFlOS1hMWE3Y2RjN2FiMGNfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzQyMV8zMTYuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ056SXdJRFUwTUNJK0NnazhhVzFoWjJVZ2QybGtkR2c5SWpjeU1DSWdhR1ZwWjJoMFBTSTFOREFpSUhoc2FXNXJPbWh5WldZOUltUmhkR0U2YVcxaFoyVXZhbkJsWnp0aVlYTmxOalFzTHpscUx6UkJRVkZUYTFwS1VtZEJRa0ZSUlVGWlFVSm5RVUZFTHk5blFTdFJNVXBHVVZaU1VGVnFiMmRhTWxGMFlXNUNiRnA1UWpKTlV6UjNTVU5vTVdNeWJIVmFlVUpLVTJ0aloxTnNRa1pTZVVJeVQwUkJjRXhEUW10YVYxcG9aRmQ0TUVsSVJqRlpWM2h3WkVoclN5ODVjMEZSZDBGSlFtZFpTRUpuVlVsQ2QyTklRMUZyU1VObmQxVkVVWGRNUTNkM1drVm9UVkJHUWpCaFNIZzBaRWRvZDJOSlExRjFTbmxCYVV4RFRXTklRMmN6UzFOM2QwMVVVVEJPUWpodVQxUXdORTFxZDNWTmVsRjVMemx6UVZGM1JVcERVV3ROUTNkM1dVUlJNRmxOYVVWalNWUkplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGt2T0VGQlJWRm5RVWRCUVdkQmQwVnBRVUZKVWtGUlRWSkJaaTlGUVVJNFFVRkJSVVpCVVVWQ1FWRkZRa0ZCUVVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWUlFVRkpRa0YzVFVOQ1FVMUdRbEZSUlVGQlFVSm1VVVZEUVhkQlJVVlJWVk5KVkVaQ1FtaE9VbGxSWTJsalVsRjVaMXBIYUVORFRrTnpZMFZXVlhSSWQwcEVUbWxqYjBsS1EyaFpXRWRDYTJGS1UxbHVTME5yY1U1RVZUSk9lbWMxVDJ0T1JWSlZXa2hUUld4TFZURlNWbFpzWkZsWFZuQnFXa2RXYlZveWFIQmhiazR3WkZoYU0yVkliRFpuTkZOR2FHOWxTV2xaY1ZOck5WTldiSEJsV1cxYWNXbHZObE5zY0hGbGIzRmhjWGx6TjFNeGRISmxOSFZpY2tOM09GUkdlSE5tU1hsamNsTXdPVlJXTVhSbVdUSmtjbWcwZFZCck5XVmlialpQYm5FNFpreDZPVkJZTWprdmFqVXJkaTlGUVVJNFFrRkJUVUpCVVVWQ1FWRkZRa0ZSUlVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWU1FVRkpRa0ZuVVVWQmQxRklRbEZSUlVGQlJVTmtkMEZDUVdkTlVrSkJWV2hOVVZsVFVWWkZTRmxZUlZSSmFrdENRMEpTUTJ0aFIzaDNVV3RxVFRGTWQwWlhTbmt3VVc5WFNrUlVhRXBtUlZoSFFtdGhTbWxqYjB0VGJ6Rk9hbU0wVDFSd1JGSkZWa2RTTUdoS1UyeE9WVlpXV2xoWFJteGhXVEpTYkZwdFpHOWhWM0I2WkVoV01tUXphRFZsYjB0RWFFbFhSMmcwYVVwcGNFdFViRXBYVjJ3MWFWcHRjVXRxY0V0WGJYQTJhWEJ4Y2t0NmRFeFhNblEzYVRWMWMweEVlRTFZUjNnNGFrcDVkRXhVTVU1WVZ6RTVhbG95ZFV4cU5VOVliVFVyYW5BMmRreDZPVkJZTWprdmFqVXJkaTloUVVGM1JFRlJRVU5GVVUxU1FVUTRRVFJYT1d0NFpIaHpkelpIZFRrd1YwRlliR2RLUWpKR1dsZHhObVJaVTI5WFNrTnJWbVk0VDFoNU1tdG1iSEZPZVVOd1luVm9TazB4U1ZreWRGZzRNMGROVmxWdE1VSk1hVmxuU0VweVVuWk1jVTgxU0hsRVFYZ3djazEwYjI4M1pESmllVGhyTVU1NE1qWnViWEkyYW1OWWN6WnhlbTVyT1VzNVVUaE9ZVWRLVEVaRGVEVkpiMjl4YlVKelUyRkhXWEJDZEU5U00yOTFaRXRYVGs1NU9FZHBhVzkxVGtndkx6SlJQVDBpUGdvSlBDOXBiV0ZuWlQ0S1BDOXpkbWMrIn19IjtzOjEyOiJvcmRlcl9jb2x1bW4iO2k6MTtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI1LTA1LTMxIDE0OjA1OjA2IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI1LTA2LTA2IDAwOjA0OjA4IjtzOjEwOiJkZWxldGVkX2F0IjtOO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjQ6e3M6MTM6Im1hbmlwdWxhdGlvbnMiO3M6NToiYXJyYXkiO3M6MTc6ImN1c3RvbV9wcm9wZXJ0aWVzIjtzOjU6ImFycmF5IjtzOjIxOiJnZW5lcmF0ZWRfY29udmVyc2lvbnMiO3M6NToiYXJyYXkiO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjU6ImFycmF5Ijt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjI6e2k6MDtzOjEyOiJvcmlnaW5hbF91cmwiO2k6MTtzOjExOiJwcmV2aWV3X3VybCI7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6Mjc6IgAqAHJlbGF0aW9uQXV0b2xvYWRDYWxsYmFjayI7TjtzOjI2OiIAKgByZWxhdGlvbkF1dG9sb2FkQ29udGV4dCI7TjtzOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czoxMzoidXNlc1VuaXF1ZUlkcyI7YjowO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTowOnt9czoxMDoiACoAZ3VhcmRlZCI7YTowOnt9czoxODoiACoAc3RyZWFtQ2h1bmtTaXplIjtpOjEwNDg1NzY7fX1zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxNDoiY29sbGVjdGlvbk5hbWUiO047czoxMzoiZm9ybUZpZWxkTmFtZSI7Tjt9czo3OiJzb2NpZXR5IjtOO31zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjI3OiIAKgByZWxhdGlvbkF1dG9sb2FkQ2FsbGJhY2siO047czoyNjoiACoAcmVsYXRpb25BdXRvbG9hZENvbnRleHQiO047czoxMDoidGltZXN0YW1wcyI7YjoxO3M6MTM6InVzZXNVbmlxdWVJZHMiO2I6MDtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMToiACoAZmlsbGFibGUiO2E6MzI6e2k6MDtzOjc6InVzZXJfaWQiO2k6MTtzOjEwOiJzb2NpZXR5X2lkIjtpOjI7czoxMzoic3ViX3NlY3Rvcl9pZCI7aTozO3M6NToidGl0bGUiO2k6NDtzOjQ6InNsdWciO2k6NTtzOjExOiJkZXNjcmlwdGlvbiI7aTo2O3M6ODoia2V5d29yZHMiO2k6NztzOjc6InB1cnBvc2UiO2k6ODtzOjEzOiJwcm9wZXJ0eV90eXBlIjtpOjk7czo5OiJwbG90X3NpemUiO2k6MTA7czoxNToicGxvdF9kaW1lbnNpb25zIjtpOjExO3M6NToicHJpY2UiO2k6MTI7czo0OiJyZW50IjtpOjEzO3M6OToicmVudF90eXBlIjtpOjE0O3M6NzoicGxvdF9ubyI7aToxNTtzOjY6InN0cmVldCI7aToxNjtzOjg6ImxvY2F0aW9uIjtpOjE3O3M6ODoibGF0aXR1ZGUiO2k6MTg7czo5OiJsb25naXR1ZGUiO2k6MTk7czo4OiJmZWF0dXJlcyI7aToyMDtzOjE3OiJuZWFyYnlfZmFjaWxpdGllcyI7aToyMTtzOjE2OiJpbnN0YWxsbWVudF9wbGFuIjtpOjIyO3M6MTI6ImJlc3Rfc2VsbGluZyI7aToyMztzOjEwOiJ0b2RheV9kZWFsIjtpOjI0O3M6ODoiYXBwcm92ZWQiO2k6MjU7czo2OiJzdGF0dXMiO2k6MjY7czo5OiJtYXBfZW1iZWQiO2k6Mjc7czoxMToidmlkZW9fZW1iZWQiO2k6Mjg7czoxNToic2hvcnRfdmlkZW9fdXJsIjtpOjI5O3M6MTA6ImV4dHJhX2RhdGEiO2k6MzA7czoxMDoiY3JlYXRlZF9ieSI7aTozMTtzOjU6InZpZXdzIjt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9czoxNjoiACoAZm9yY2VEZWxldGluZyI7YjowO31pOjQ7TzoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI6MzM6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToicGdzcWwiO3M6ODoiACoAdGFibGUiO3M6MTA6InByb3BlcnRpZXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMDp7czoyOiJpZCI7aTozO3M6NToidGl0bGUiO3M6MTU6ImIxIDUgbWFybGEgcGxvdCI7czo0OiJzbHVnIjtzOjE1OiJiMS01LW1hcmxhLXBsb3QiO3M6NToicHJpY2UiO2k6NjAwMDAwMDtzOjc6InB1cnBvc2UiO3M6NDoic2FsZSI7czo4OiJsb2NhdGlvbiI7TjtzOjU6InZpZXdzIjtpOjA7czo5OiJwbG90X3NpemUiO3M6NzoiNSBNYXJsYSI7czo4OiJmZWF0dXJlcyI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI1LTA1LTMxIDE0OjAxOjE0Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTA6e3M6MjoiaWQiO2k6MztzOjU6InRpdGxlIjtzOjE1OiJiMSA1IG1hcmxhIHBsb3QiO3M6NDoic2x1ZyI7czoxNToiYjEtNS1tYXJsYS1wbG90IjtzOjU6InByaWNlIjtpOjYwMDAwMDA7czo3OiJwdXJwb3NlIjtzOjQ6InNhbGUiO3M6ODoibG9jYXRpb24iO047czo1OiJ2aWV3cyI7aTowO3M6OToicGxvdF9zaXplIjtzOjc6IjUgTWFybGEiO3M6ODoiZmVhdHVyZXMiO047czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNS0wNS0zMSAxNDowMToxNCI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6OTp7czo4OiJmZWF0dXJlcyI7czo1OiJhcnJheSI7czoxNzoibmVhcmJ5X2ZhY2lsaXRpZXMiO3M6NToiYXJyYXkiO3M6MTY6Imluc3RhbGxtZW50X3BsYW4iO3M6NToiYXJyYXkiO3M6MTI6ImJlc3Rfc2VsbGluZyI7czo3OiJib29sZWFuIjtzOjEwOiJ0b2RheV9kZWFsIjtzOjc6ImJvb2xlYW4iO3M6ODoiYXBwcm92ZWQiO3M6NzoiYm9vbGVhbiI7czo4OiJsYXRpdHVkZSI7czo1OiJmbG9hdCI7czo5OiJsb25naXR1ZGUiO3M6NToiZmxvYXQiO3M6MTA6ImRlbGV0ZWRfYXQiO3M6ODoiZGF0ZXRpbWUiO31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MTp7aTowO3M6MTg6InByb3BlcnR5X2ltYWdlX3VybCI7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6Mjp7czo1OiJtZWRpYSI7Tzo3MToiU3BhdGllXE1lZGlhTGlicmFyeVxNZWRpYUNvbGxlY3Rpb25zXE1vZGVsc1xDb2xsZWN0aW9uc1xNZWRpYUNvbGxlY3Rpb24iOjQ6e3M6ODoiACoAaXRlbXMiO2E6MTp7aTowO086NDk6IlNwYXRpZVxNZWRpYUxpYnJhcnlcTWVkaWFDb2xsZWN0aW9uc1xNb2RlbHNcTWVkaWEiOjMzOntzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6InBnc3FsIjtzOjg6IgAqAHRhYmxlIjtzOjU6Im1lZGlhIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6MTk6e3M6MjoiaWQiO2k6NztzOjEwOiJtb2RlbF90eXBlIjtzOjE5OiJBcHBcTW9kZWxzXFByb3BlcnR5IjtzOjg6Im1vZGVsX2lkIjtpOjM7czo0OiJ1dWlkIjtzOjM2OiI2YWVjMWU2MS0yMjZkLTQ5OTktYjM0OC1hZmZhN2Y1NGUwMGQiO3M6MTU6ImNvbGxlY3Rpb25fbmFtZSI7czoxNDoicHJvcGVydHlfaW1hZ2UiO3M6NDoibmFtZSI7czozNjoiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1IjtzOjk6ImZpbGVfbmFtZSI7czo0MDoiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1LmpwZyI7czo5OiJtaW1lX3R5cGUiO3M6MTA6ImltYWdlL2pwZWciO3M6NDoiZGlzayI7czo2OiJwdWJsaWMiO3M6MTY6ImNvbnZlcnNpb25zX2Rpc2siO3M6NjoicHVibGljIjtzOjQ6InNpemUiO2k6MTc1NDc1O3M6MTM6Im1hbmlwdWxhdGlvbnMiO3M6MjoiW10iO3M6MTc6ImN1c3RvbV9wcm9wZXJ0aWVzIjtzOjI6IltdIjtzOjIxOiJnZW5lcmF0ZWRfY29udmVyc2lvbnMiO3M6MTQ6InsidGh1bWIiOnRydWV9IjtzOjE3OiJyZXNwb25zaXZlX2ltYWdlcyI7czo1MjQzOiJ7InRodW1iIjp7InVybHMiOlsiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1X19fdGh1bWJfMjcwXzM2MC5qcGciLCI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX190aHVtYl8yMjVfMzAwLmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX3RodW1iXzE4OV8yNTIuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ01qY3dJRE0yTUNJK0NnazhhVzFoWjJVZ2QybGtkR2c5SWpJM01DSWdhR1ZwWjJoMFBTSXpOakFpSUhoc2FXNXJPbWh5WldZOUltUmhkR0U2YVcxaFoyVXZhbkJsWnp0aVlYTmxOalFzTHpscUx6UkJRVkZUYTFwS1VtZEJRa0ZSUlVGWlFVSm5RVUZFTHk5blFTdFJNVXBHVVZaU1VGVnFiMmRhTWxGMFlXNUNiRnA1UWpKTlV6UjNTVU5vTVdNeWJIVmFlVUpLVTJ0aloxTnNRa1pTZVVJeVQwUkJjRXhEUW10YVYxcG9aRmQ0TUVsSVJqRlpWM2h3WkVoclN5ODVjMEZSZDBGSlFtZFpTRUpuVlVsQ2QyTklRMUZyU1VObmQxVkVVWGRNUTNkM1drVm9UVkJHUWpCaFNIZzBaRWRvZDJOSlExRjFTbmxCYVV4RFRXTklRMmN6UzFOM2QwMVVVVEJPUWpodVQxUXdORTFxZDNWTmVsRjVMemx6UVZGM1JVcERVV3ROUTNkM1dVUlJNRmxOYVVWalNWUkplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGt2T0VGQlJWRm5RVXQzUVdkQmQwVnBRVUZKVWtGUlRWSkJaaTlGUVVJNFFVRkJSVVpCVVVWQ1FWRkZRa0ZCUVVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWUlFVRkpRa0YzVFVOQ1FVMUdRbEZSUlVGQlFVSm1VVVZEUVhkQlJVVlJWVk5KVkVaQ1FtaE9VbGxSWTJsalVsRjVaMXBIYUVORFRrTnpZMFZXVlhSSWQwcEVUbWxqYjBsS1EyaFpXRWRDYTJGS1UxbHVTME5yY1U1RVZUSk9lbWMxVDJ0T1JWSlZXa2hUUld4TFZURlNWbFpzWkZsWFZuQnFXa2RXYlZveWFIQmhiazR3WkZoYU0yVkliRFpuTkZOR2FHOWxTV2xaY1ZOck5WTldiSEJsV1cxYWNXbHZObE5zY0hGbGIzRmhjWGx6TjFNeGRISmxOSFZpY2tOM09GUkdlSE5tU1hsamNsTXdPVlJXTVhSbVdUSmtjbWcwZFZCck5XVmlialpQYm5FNFpreDZPVkJZTWprdmFqVXJkaTlGUVVJNFFrRkJUVUpCVVVWQ1FWRkZRa0ZSUlVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWU1FVRkpRa0ZuVVVWQmQxRklRbEZSUlVGQlJVTmtkMEZDUVdkTlVrSkJWV2hOVVZsVFVWWkZTRmxZUlZSSmFrdENRMEpTUTJ0aFIzaDNVV3RxVFRGTWQwWlhTbmt3VVc5WFNrUlVhRXBtUlZoSFFtdGhTbWxqYjB0VGJ6Rk9hbU0wVDFSd1JGSkZWa2RTTUdoS1UyeE9WVlpXV2xoWFJteGhXVEpTYkZwdFpHOWhWM0I2WkVoV01tUXphRFZsYjB0RWFFbFhSMmcwYVVwcGNFdFViRXBYVjJ3MWFWcHRjVXRxY0V0WGJYQTJhWEJ4Y2t0NmRFeFhNblEzYVRWMWMweEVlRTFZUjNnNGFrcDVkRXhVTVU1WVZ6RTVhbG95ZFV4cU5VOVliVFVyYW5BMmRreDZPVkJZTWprdmFqVXJkaTloUVVGM1JFRlJRVU5GVVUxU1FVUTRRVFZJZURkbU0xWTFURFZEVW5Sek9XTldaMkZPYjBWeE5HMXNWV2RXTjBSeFQyMVhiM1F2VFd4cFZUUTNhMVpUUm1oYVpscEVTV3B5ZEhnd09VczFWbGRrTjBwSGFtZHVjVEpqYzJ4eVIwbDNWMUI2VERCdmRXNUZkWGRrYUZkdFpGQk1lV1pNZVhBMlZXOHdaVkYwYTBGWlNISlVOVlZ1WlZkdk4zVXhhMlJRTkhGdFJWZHBVSFJRZWxseWVucFVZakprTkZkU2VUSk5NWEVyU1dSVmJWaE5WWGg2YW5SWFRHSTJkRU56VjBOdlYyNUNkRXhSYVdFeFQzb3dhVFJYVVhGemMxSXlURE40VjBvMGNERnRZVEoxVkVoaGEzRnNZbTVvZWxWVmRrbE9hVWxEVWpONFYySTBhekJMVnpodFdqRkhUVEZ2TlRaWFlVVnZjVGszYlZZMGFVSnVka2RQTURSeWJUVTNXVzFTUm5oblJURXlNMmxHVmtGQ1FVRk9ZekkwUWt0YVNHVnpTWFY2VDJ4NFZXOHpVRkptUTNWdVVsZFBia2swUjFkWlZtWjJhWEowYmtaTk1Hb3ZRVXBDWTFnck4xSmpPVXMyV1ZSMlEzcFBUMVZNVTNWbUx6bHJQU0krQ2drOEwybHRZV2RsUGdvOEwzTjJaejQ9In0sIm1lZGlhX2xpYnJhcnlfb3JpZ2luYWwiOnsidXJscyI6WyI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzk2MF8xMjgwLmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfODAzXzEwNzEuanBnIiwiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF82NzJfODk2LmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNTYyXzc0OS5qcGciLCI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzQ3MF82MjcuanBnIiwiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8zOTNfNTI0LmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMzI5XzQzOS5qcGciLCI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzI3NV8zNjcuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ09UWXdJREV5T0RBaVBnb0pQR2x0WVdkbElIZHBaSFJvUFNJNU5qQWlJR2hsYVdkb2REMGlNVEk0TUNJZ2VHeHBibXM2YUhKbFpqMGlaR0YwWVRwcGJXRm5aUzlxY0dWbk8ySmhjMlUyTkN3dk9Xb3ZORUZCVVZOcldrcFNaMEZDUVZGRlFWbEJRbWRCUVVRdkwyZEJLMUV4U2taUlZsSlFWV3B2WjFveVVYUmhia0pzV25sQ01rMVROSGRKUTJneFl6SnNkVnA1UWtwVGEyTm5VMnhDUmxKNVFqSlBSRUZ3VEVOQ2ExcFhXbWhrVjNnd1NVaEdNVmxYZUhCa1NHdExMemx6UVZGM1FVbENaMWxJUW1kVlNVSjNZMGhEVVd0SlEyZDNWVVJSZDB4RGQzZGFSV2hOVUVaQ01HRkllRFJrUjJoM1kwbERVWFZLZVVGcFRFTk5ZMGhEWnpOTFUzZDNUVlJSTUU1Q09HNVBWREEwVFdwM2RVMTZVWGt2T1hOQlVYZEZTa05SYTAxRGQzZFpSRkV3V1UxcFJXTkpWRWw1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVM4NFFVRkZVV2RCUzNkQlowRjNSV2xCUVVsU1FWRk5Va0ZtTDBWQlFqaEJRVUZGUmtGUlJVSkJVVVZDUVVGQlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWRkJRVWxDUVhkTlEwSkJUVVpDVVZGRlFVRkJRbVpSUlVOQmQwRkZSVkZWVTBsVVJrSkNhRTVTV1ZGamFXTlNVWGxuV2tkb1EwTk9RM05qUlZaVmRFaDNTa1JPYVdOdlNVcERhRmxZUjBKcllVcFRXVzVMUTJ0eFRrUlZNazU2WnpWUGEwNUZVbFZhU0ZORmJFdFZNVkpXVm14a1dWZFdjR3BhUjFadFdqSm9jR0Z1VGpCa1dGb3paVWhzTm1jMFUwWm9iMlZKYVZseFUyczFVMVpzY0dWWmJWcHhhVzgyVTJ4d2NXVnZjV0Z4ZVhNM1V6RjBjbVUwZFdKeVEzYzRWRVo0YzJaSmVXTnlVekE1VkZZeGRHWlpNbVJ5YURSMVVHczFaV0p1Tms5dWNUaG1USG81VUZneU9TOXFOU3QyTDBWQlFqaENRVUZOUWtGUlJVSkJVVVZDUVZGRlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWSkJRVWxDUVdkUlJVRjNVVWhDVVZGRlFVRkZRMlIzUVVKQlowMVNRa0ZWYUUxUldWTlJWa1ZJV1ZoRlZFbHFTMEpEUWxKRGEyRkhlSGRSYTJwTk1VeDNSbGRLZVRCUmIxZEtSRlJvU21aRldFZENhMkZLYVdOdlMxTnZNVTVxWXpSUFZIQkVVa1ZXUjFJd2FFcFRiRTVWVmxaYVdGZEdiR0ZaTWxKc1dtMWtiMkZYY0hwa1NGWXlaRE5vTldWdlMwUm9TVmRIYURScFNtbHdTMVJzU2xkWGJEVnBXbTF4UzJwd1MxZHRjRFpwY0hGeVMzcDBURmN5ZERkcE5YVnpURVI0VFZoSGVEaHFTbmwwVEZReFRsaFhNVGxxV2pKMVRHbzFUMWh0TlN0cWNEWjJUSG81VUZneU9TOXFOU3QyTDJGQlFYZEVRVkZCUTBWUlRWSkJSRGhCTlVoNE4yWXpWalZNTlVOU2RITTVZMVpuWVU1dlJYRTBiV3hWWjFZM1JIRlBiVmR2ZEM5TmJHbFZORGRyVmxOR2FGcERNRTFwVDNVelNGUXdjbXhXV2pOemEyRTRhV1Z5V25sNVYzTlphVUpaTDAxMlUyazJZMU0zUWpKR1lWcHpRemh1ZVRoeFpXeFBSMnA1Um5SM1FYZFFWMjU1Y0U4NGRGRjFOMWRYYURBemFYVmFXWFJGWm1GbWJYaFlibVZ0TTNNM2VFMXFiSE5hY2xjNFVUWndUVTE0VkVoUFR6RlpkSFp4TUV0U1dVdG9ZVWxPY0dGRlZGZHdNbVZyV0VONVJsWnNhV0paYnpZeGFXVkxUbHB0ZERkcmVESndTMjlMTTFCRWJXOTRNMnRIZUVWNVVqTjRWMkkwYXpCUFlUZHRURzlOV25KV01VaGhlbEZzUmxoMlkzbDJSVkZOTVRSNGVIaFlUbnBYZUdGU1JuaG5SVEV5TTJsR1JrRkNRVWRoTlhSM1ExVjVUemxqT0ZjMGN6WnVSbE5xWXpsSE9FczJaRVpaTm1OcVowRnpkM0V2WmtaWVlrOUxhakJtTDJ0R2VHWTNkRVl4TUhKeGFFNTFUbTFqVlc5S1UzVm1MeTlhSWo0S0NUd3ZhVzFoWjJVK0Nqd3ZjM1puUGc9PSJ9fSI7czoxMjoib3JkZXJfY29sdW1uIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNS0wNS0zMSAxNDowMToxNCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNi0wNiAwMDowNDowOCI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTk6e3M6MjoiaWQiO2k6NztzOjEwOiJtb2RlbF90eXBlIjtzOjE5OiJBcHBcTW9kZWxzXFByb3BlcnR5IjtzOjg6Im1vZGVsX2lkIjtpOjM7czo0OiJ1dWlkIjtzOjM2OiI2YWVjMWU2MS0yMjZkLTQ5OTktYjM0OC1hZmZhN2Y1NGUwMGQiO3M6MTU6ImNvbGxlY3Rpb25fbmFtZSI7czoxNDoicHJvcGVydHlfaW1hZ2UiO3M6NDoibmFtZSI7czozNjoiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1IjtzOjk6ImZpbGVfbmFtZSI7czo0MDoiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1LmpwZyI7czo5OiJtaW1lX3R5cGUiO3M6MTA6ImltYWdlL2pwZWciO3M6NDoiZGlzayI7czo2OiJwdWJsaWMiO3M6MTY6ImNvbnZlcnNpb25zX2Rpc2siO3M6NjoicHVibGljIjtzOjQ6InNpemUiO2k6MTc1NDc1O3M6MTM6Im1hbmlwdWxhdGlvbnMiO3M6MjoiW10iO3M6MTc6ImN1c3RvbV9wcm9wZXJ0aWVzIjtzOjI6IltdIjtzOjIxOiJnZW5lcmF0ZWRfY29udmVyc2lvbnMiO3M6MTQ6InsidGh1bWIiOnRydWV9IjtzOjE3OiJyZXNwb25zaXZlX2ltYWdlcyI7czo1MjQzOiJ7InRodW1iIjp7InVybHMiOlsiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1X19fdGh1bWJfMjcwXzM2MC5qcGciLCI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX190aHVtYl8yMjVfMzAwLmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX3RodW1iXzE4OV8yNTIuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ01qY3dJRE0yTUNJK0NnazhhVzFoWjJVZ2QybGtkR2c5SWpJM01DSWdhR1ZwWjJoMFBTSXpOakFpSUhoc2FXNXJPbWh5WldZOUltUmhkR0U2YVcxaFoyVXZhbkJsWnp0aVlYTmxOalFzTHpscUx6UkJRVkZUYTFwS1VtZEJRa0ZSUlVGWlFVSm5RVUZFTHk5blFTdFJNVXBHVVZaU1VGVnFiMmRhTWxGMFlXNUNiRnA1UWpKTlV6UjNTVU5vTVdNeWJIVmFlVUpLVTJ0aloxTnNRa1pTZVVJeVQwUkJjRXhEUW10YVYxcG9aRmQ0TUVsSVJqRlpWM2h3WkVoclN5ODVjMEZSZDBGSlFtZFpTRUpuVlVsQ2QyTklRMUZyU1VObmQxVkVVWGRNUTNkM1drVm9UVkJHUWpCaFNIZzBaRWRvZDJOSlExRjFTbmxCYVV4RFRXTklRMmN6UzFOM2QwMVVVVEJPUWpodVQxUXdORTFxZDNWTmVsRjVMemx6UVZGM1JVcERVV3ROUTNkM1dVUlJNRmxOYVVWalNWUkplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGt2T0VGQlJWRm5RVXQzUVdkQmQwVnBRVUZKVWtGUlRWSkJaaTlGUVVJNFFVRkJSVVpCVVVWQ1FWRkZRa0ZCUVVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWUlFVRkpRa0YzVFVOQ1FVMUdRbEZSUlVGQlFVSm1VVVZEUVhkQlJVVlJWVk5KVkVaQ1FtaE9VbGxSWTJsalVsRjVaMXBIYUVORFRrTnpZMFZXVlhSSWQwcEVUbWxqYjBsS1EyaFpXRWRDYTJGS1UxbHVTME5yY1U1RVZUSk9lbWMxVDJ0T1JWSlZXa2hUUld4TFZURlNWbFpzWkZsWFZuQnFXa2RXYlZveWFIQmhiazR3WkZoYU0yVkliRFpuTkZOR2FHOWxTV2xaY1ZOck5WTldiSEJsV1cxYWNXbHZObE5zY0hGbGIzRmhjWGx6TjFNeGRISmxOSFZpY2tOM09GUkdlSE5tU1hsamNsTXdPVlJXTVhSbVdUSmtjbWcwZFZCck5XVmlialpQYm5FNFpreDZPVkJZTWprdmFqVXJkaTlGUVVJNFFrRkJUVUpCVVVWQ1FWRkZRa0ZSUlVGQlFVRkJRVUZCUWtGblRVVkNVVmxJUTBGclMwTXZMMFZCVEZWU1FVRkpRa0ZuVVVWQmQxRklRbEZSUlVGQlJVTmtkMEZDUVdkTlVrSkJWV2hOVVZsVFVWWkZTRmxZUlZSSmFrdENRMEpTUTJ0aFIzaDNVV3RxVFRGTWQwWlhTbmt3VVc5WFNrUlVhRXBtUlZoSFFtdGhTbWxqYjB0VGJ6Rk9hbU0wVDFSd1JGSkZWa2RTTUdoS1UyeE9WVlpXV2xoWFJteGhXVEpTYkZwdFpHOWhWM0I2WkVoV01tUXphRFZsYjB0RWFFbFhSMmcwYVVwcGNFdFViRXBYVjJ3MWFWcHRjVXRxY0V0WGJYQTJhWEJ4Y2t0NmRFeFhNblEzYVRWMWMweEVlRTFZUjNnNGFrcDVkRXhVTVU1WVZ6RTVhbG95ZFV4cU5VOVliVFVyYW5BMmRreDZPVkJZTWprdmFqVXJkaTloUVVGM1JFRlJRVU5GVVUxU1FVUTRRVFZJZURkbU0xWTFURFZEVW5Sek9XTldaMkZPYjBWeE5HMXNWV2RXTjBSeFQyMVhiM1F2VFd4cFZUUTNhMVpUUm1oYVpscEVTV3B5ZEhnd09VczFWbGRrTjBwSGFtZHVjVEpqYzJ4eVIwbDNWMUI2VERCdmRXNUZkWGRrYUZkdFpGQk1lV1pNZVhBMlZXOHdaVkYwYTBGWlNISlVOVlZ1WlZkdk4zVXhhMlJRTkhGdFJWZHBVSFJRZWxseWVucFVZakprTkZkU2VUSk5NWEVyU1dSVmJWaE5WWGg2YW5SWFRHSTJkRU56VjBOdlYyNUNkRXhSYVdFeFQzb3dhVFJYVVhGemMxSXlURE40VjBvMGNERnRZVEoxVkVoaGEzRnNZbTVvZWxWVmRrbE9hVWxEVWpONFYySTBhekJMVnpodFdqRkhUVEZ2TlRaWFlVVnZjVGszYlZZMGFVSnVka2RQTURSeWJUVTNXVzFTUm5oblJURXlNMmxHVmtGQ1FVRk9ZekkwUWt0YVNHVnpTWFY2VDJ4NFZXOHpVRkptUTNWdVVsZFBia2swUjFkWlZtWjJhWEowYmtaTk1Hb3ZRVXBDWTFnck4xSmpPVXMyV1ZSMlEzcFBUMVZNVTNWbUx6bHJQU0krQ2drOEwybHRZV2RsUGdvOEwzTjJaejQ9In0sIm1lZGlhX2xpYnJhcnlfb3JpZ2luYWwiOnsidXJscyI6WyI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzk2MF8xMjgwLmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfODAzXzEwNzEuanBnIiwiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF82NzJfODk2LmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfNTYyXzc0OS5qcGciLCI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzQ3MF82MjcuanBnIiwiNDVhMDYyNjMtOTBhOC00ZmExLThhMmQtNDk2MTlmZjk2ZGI1X19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8zOTNfNTI0LmpwZyIsIjQ1YTA2MjYzLTkwYTgtNGZhMS04YTJkLTQ5NjE5ZmY5NmRiNV9fX21lZGlhX2xpYnJhcnlfb3JpZ2luYWxfMzI5XzQzOS5qcGciLCI0NWEwNjI2My05MGE4LTRmYTEtOGEyZC00OTYxOWZmOTZkYjVfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzI3NV8zNjcuanBnIl0sImJhc2U2NHN2ZyI6ImRhdGE6aW1hZ2VcL3N2Zyt4bWw7YmFzZTY0LFBDRkVUME5VV1ZCRklITjJaeUJRVlVKTVNVTWdJaTB2TDFjelF5OHZSRlJFSUZOV1J5QXhMakV2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZSM0poY0docFkzTXZVMVpITHpFdU1TOUVWRVF2YzNabk1URXVaSFJrSWo0S1BITjJaeUIyWlhKemFXOXVQU0l4TGpFaUlIaHRiRzV6UFNKb2RIUndPaTh2ZDNkM0xuY3pMbTl5Wnk4eU1EQXdMM04yWnlJZ2VHMXNibk02ZUd4cGJtczlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5MekU1T1RrdmVHeHBibXNpSUhodGJEcHpjR0ZqWlQwaWNISmxjMlZ5ZG1VaUlIZzlJakFpQ2lCNVBTSXdJaUIyYVdWM1FtOTRQU0l3SURBZ09UWXdJREV5T0RBaVBnb0pQR2x0WVdkbElIZHBaSFJvUFNJNU5qQWlJR2hsYVdkb2REMGlNVEk0TUNJZ2VHeHBibXM2YUhKbFpqMGlaR0YwWVRwcGJXRm5aUzlxY0dWbk8ySmhjMlUyTkN3dk9Xb3ZORUZCVVZOcldrcFNaMEZDUVZGRlFWbEJRbWRCUVVRdkwyZEJLMUV4U2taUlZsSlFWV3B2WjFveVVYUmhia0pzV25sQ01rMVROSGRKUTJneFl6SnNkVnA1UWtwVGEyTm5VMnhDUmxKNVFqSlBSRUZ3VEVOQ2ExcFhXbWhrVjNnd1NVaEdNVmxYZUhCa1NHdExMemx6UVZGM1FVbENaMWxJUW1kVlNVSjNZMGhEVVd0SlEyZDNWVVJSZDB4RGQzZGFSV2hOVUVaQ01HRkllRFJrUjJoM1kwbERVWFZLZVVGcFRFTk5ZMGhEWnpOTFUzZDNUVlJSTUU1Q09HNVBWREEwVFdwM2RVMTZVWGt2T1hOQlVYZEZTa05SYTAxRGQzZFpSRkV3V1UxcFJXTkpWRWw1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVM4NFFVRkZVV2RCUzNkQlowRjNSV2xCUVVsU1FWRk5Va0ZtTDBWQlFqaEJRVUZGUmtGUlJVSkJVVVZDUVVGQlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWRkJRVWxDUVhkTlEwSkJUVVpDVVZGRlFVRkJRbVpSUlVOQmQwRkZSVkZWVTBsVVJrSkNhRTVTV1ZGamFXTlNVWGxuV2tkb1EwTk9RM05qUlZaVmRFaDNTa1JPYVdOdlNVcERhRmxZUjBKcllVcFRXVzVMUTJ0eFRrUlZNazU2WnpWUGEwNUZVbFZhU0ZORmJFdFZNVkpXVm14a1dWZFdjR3BhUjFadFdqSm9jR0Z1VGpCa1dGb3paVWhzTm1jMFUwWm9iMlZKYVZseFUyczFVMVpzY0dWWmJWcHhhVzgyVTJ4d2NXVnZjV0Z4ZVhNM1V6RjBjbVUwZFdKeVEzYzRWRVo0YzJaSmVXTnlVekE1VkZZeGRHWlpNbVJ5YURSMVVHczFaV0p1Tms5dWNUaG1USG81VUZneU9TOXFOU3QyTDBWQlFqaENRVUZOUWtGUlJVSkJVVVZDUVZGRlFVRkJRVUZCUVVGQ1FXZE5SVUpSV1VoRFFXdExReTh2UlVGTVZWSkJRVWxDUVdkUlJVRjNVVWhDVVZGRlFVRkZRMlIzUVVKQlowMVNRa0ZWYUUxUldWTlJWa1ZJV1ZoRlZFbHFTMEpEUWxKRGEyRkhlSGRSYTJwTk1VeDNSbGRLZVRCUmIxZEtSRlJvU21aRldFZENhMkZLYVdOdlMxTnZNVTVxWXpSUFZIQkVVa1ZXUjFJd2FFcFRiRTVWVmxaYVdGZEdiR0ZaTWxKc1dtMWtiMkZYY0hwa1NGWXlaRE5vTldWdlMwUm9TVmRIYURScFNtbHdTMVJzU2xkWGJEVnBXbTF4UzJwd1MxZHRjRFpwY0hGeVMzcDBURmN5ZERkcE5YVnpURVI0VFZoSGVEaHFTbmwwVEZReFRsaFhNVGxxV2pKMVRHbzFUMWh0TlN0cWNEWjJUSG81VUZneU9TOXFOU3QyTDJGQlFYZEVRVkZCUTBWUlRWSkJSRGhCTlVoNE4yWXpWalZNTlVOU2RITTVZMVpuWVU1dlJYRTBiV3hWWjFZM1JIRlBiVmR2ZEM5TmJHbFZORGRyVmxOR2FGcERNRTFwVDNVelNGUXdjbXhXV2pOemEyRTRhV1Z5V25sNVYzTlphVUpaTDAxMlUyazJZMU0zUWpKR1lWcHpRemh1ZVRoeFpXeFBSMnA1Um5SM1FYZFFWMjU1Y0U4NGRGRjFOMWRYYURBemFYVmFXWFJGWm1GbWJYaFlibVZ0TTNNM2VFMXFiSE5hY2xjNFVUWndUVTE0VkVoUFR6RlpkSFp4TUV0U1dVdG9ZVWxPY0dGRlZGZHdNbVZyV0VONVJsWnNhV0paYnpZeGFXVkxUbHB0ZERkcmVESndTMjlMTTFCRWJXOTRNMnRIZUVWNVVqTjRWMkkwYXpCUFlUZHRURzlOV25KV01VaGhlbEZzUmxoMlkzbDJSVkZOTVRSNGVIaFlUbnBYZUdGU1JuaG5SVEV5TTJsR1JrRkNRVWRoTlhSM1ExVjVUemxqT0ZjMGN6WnVSbE5xWXpsSE9FczJaRVpaTm1OcVowRnpkM0V2WmtaWVlrOUxhakJtTDJ0R2VHWTNkRVl4TUhKeGFFNTFUbTFqVlc5S1UzVm1MeTlhSWo0S0NUd3ZhVzFoWjJVK0Nqd3ZjM1puUGc9PSJ9fSI7czoxMjoib3JkZXJfY29sdW1uIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNS0wNS0zMSAxNDowMToxNCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNi0wNiAwMDowNDowOCI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTo0OntzOjEzOiJtYW5pcHVsYXRpb25zIjtzOjU6ImFycmF5IjtzOjE3OiJjdXN0b21fcHJvcGVydGllcyI7czo1OiJhcnJheSI7czoyMToiZ2VuZXJhdGVkX2NvbnZlcnNpb25zIjtzOjU6ImFycmF5IjtzOjE3OiJyZXNwb25zaXZlX2ltYWdlcyI7czo1OiJhcnJheSI7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjIxOiIAKgBhdHRyaWJ1dGVDYXN0Q2FjaGUiO2E6MDp7fXM6MTM6IgAqAGRhdGVGb3JtYXQiO047czoxMDoiACoAYXBwZW5kcyI7YToyOntpOjA7czoxMjoib3JpZ2luYWxfdXJsIjtpOjE7czoxMToicHJldmlld191cmwiO31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjA6e31zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjI3OiIAKgByZWxhdGlvbkF1dG9sb2FkQ2FsbGJhY2siO047czoyNjoiACoAcmVsYXRpb25BdXRvbG9hZENvbnRleHQiO047czoxMDoidGltZXN0YW1wcyI7YjoxO3M6MTM6InVzZXNVbmlxdWVJZHMi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OjE6e2k6MDtzOjE4OiJwcm9wZXJ0eV9pbWFnZV91cmwiO31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjI6e3M6NToibWVkaWEiO086NzE6IlNwYXRpZVxNZWRpYUxpYnJhcnlcTWVkaWFDb2xsZWN0aW9uc1xNb2RlbHNcQ29sbGVjdGlvbnNcTWVkaWFDb2xsZWN0aW9uIjo0OntzOjg6IgAqAGl0ZW1zIjthOjE6e2k6MDtPOjQ5OiJTcGF0aWVcTWVkaWFMaWJyYXJ5XE1lZGlhQ29sbGVjdGlvbnNcTW9kZWxzXE1lZGlhIjozMzp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJwZ3NxbCI7czo4OiIAKgB0YWJsZSI7czo1OiJtZWRpYSI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE5OntzOjI6ImlkIjtpOjY7czoxMDoibW9kZWxfdHlwZSI7czoxOToiQXBwXE1vZGVsc1xQcm9wZXJ0eSI7czo4OiJtb2RlbF9pZCI7aToyO3M6NDoidXVpZCI7czozNjoiNTlkODA4NmYtZDBiOS00MmZjLTk1MTgtNmZmMzA3N2I2NDRlIjtzOjE1OiJjb2xsZWN0aW9uX25hbWUiO3M6MTQ6InByb3BlcnR5X2ltYWdlIjtzOjQ6Im5hbWUiO3M6MTk6Imd1bGJhcmcgbm9uIGRldmVsb3AiO3M6OToiZmlsZV9uYW1lIjtzOjI0OiJndWxiYXJnLW5vbi1kZXZlbG9wLmpwZWciO3M6OToibWltZV90eXBlIjtzOjEwOiJpbWFnZS9qcGVnIjtzOjQ6ImRpc2siO3M6NjoicHVibGljIjtzOjE2OiJjb252ZXJzaW9uc19kaXNrIjtzOjY6InB1YmxpYyI7czo0OiJzaXplIjtpOjY2Mzk7czoxMzoibWFuaXB1bGF0aW9ucyI7czoyOiJbXSI7czoxNzoiY3VzdG9tX3Byb3BlcnRpZXMiO3M6MjoiW10iO3M6MjE6ImdlbmVyYXRlZF9jb252ZXJzaW9ucyI7czoxNDoieyJ0aHVtYiI6dHJ1ZX0iO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjM5MTg6InsidGh1bWIiOnsidXJscyI6WyJndWxiYXJnLW5vbi1kZXZlbG9wX19fdGh1bWJfNzk2XzM2MC5qcGciLCJndWxiYXJnLW5vbi1kZXZlbG9wX19fdGh1bWJfNjY1XzMwMS5qcGciLCJndWxiYXJnLW5vbi1kZXZlbG9wX19fdGh1bWJfNTU3XzI1Mi5qcGciXSwiYmFzZTY0c3ZnIjoiZGF0YTppbWFnZVwvc3ZnK3htbDtiYXNlNjQsUENGRVQwTlVXVkJGSUhOMlp5QlFWVUpNU1VNZ0lpMHZMMWN6UXk4dlJGUkVJRk5XUnlBeExqRXZMMFZPSWlBaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdlIzSmhjR2hwWTNNdlUxWkhMekV1TVM5RVZFUXZjM1puTVRFdVpIUmtJajRLUEhOMlp5QjJaWEp6YVc5dVBTSXhMakVpSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh5TURBd0wzTjJaeUlnZUcxc2JuTTZlR3hwYm1zOUltaDBkSEE2THk5M2QzY3Vkek11YjNKbkx6RTVPVGt2ZUd4cGJtc2lJSGh0YkRwemNHRmpaVDBpY0hKbGMyVnlkbVVpSUhnOUlqQWlDaUI1UFNJd0lpQjJhV1YzUW05NFBTSXdJREFnTnprMklETTJNQ0krQ2drOGFXMWhaMlVnZDJsa2RHZzlJamM1TmlJZ2FHVnBaMmgwUFNJek5qQWlJSGhzYVc1ck9taHlaV1k5SW1SaGRHRTZhVzFoWjJVdmFuQmxaenRpWVhObE5qUXNMemxxTHpSQlFWRlRhMXBLVW1kQlFrRlJSVUZaUVVKblFVRkVMeTluUVN0Uk1VcEdVVlpTVUZWcWIyZGFNbEYwWVc1Q2JGcDVRakpOVXpSM1NVTm9NV015YkhWYWVVSktVMnRqWjFOc1FrWlNlVUl5VDBSQmNFeERRbXRhVjFwb1pGZDRNRWxJUmpGWlYzaHdaRWhyU3k4NWMwRlJkMEZKUW1kWlNFSm5WVWxDZDJOSVExRnJTVU5uZDFWRVVYZE1RM2QzV2tWb1RWQkdRakJoU0hnMFpFZG9kMk5KUTFGMVNubEJhVXhEVFdOSVEyY3pTMU4zZDAxVVVUQk9Ramh1VDFRd05FMXFkM1ZOZWxGNUx6bHpRVkYzUlVwRFVXdE5RM2QzV1VSUk1GbE5hVVZqU1ZSSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYa3ZPRUZCUlZGblFVUm5RV2RCZDBWcFFVRkpVa0ZSVFZKQlppOUZRVUk0UVVGQlJVWkJVVVZDUVZGRlFrRkJRVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZSUVVGSlFrRjNUVU5DUVUxR1FsRlJSVUZCUVVKbVVVVkRRWGRCUlVWUlZWTkpWRVpDUW1oT1VsbFJZMmxqVWxGNVoxcEhhRU5EVGtOelkwVldWWFJJZDBwRVRtbGpiMGxLUTJoWldFZENhMkZLVTFsdVMwTnJjVTVFVlRKT2VtYzFUMnRPUlZKVldraFRSV3hMVlRGU1ZsWnNaRmxYVm5CcVdrZFdiVm95YUhCaGJrNHdaRmhhTTJWSWJEWm5ORk5HYUc5bFNXbFpjVk5yTlZOV2JIQmxXVzFhY1dsdk5sTnNjSEZsYjNGaGNYbHpOMU14ZEhKbE5IVmlja04zT0ZSR2VITm1TWGxqY2xNd09WUldNWFJtV1RKa2NtZzBkVkJyTldWaWJqWlBibkU0Wmt4Nk9WQllNamt2YWpVcmRpOUZRVUk0UWtGQlRVSkJVVVZDUVZGRlFrRlJSVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZTUVVGSlFrRm5VVVZCZDFGSVFsRlJSVUZCUlVOa2QwRkNRV2ROVWtKQlZXaE5VVmxUVVZaRlNGbFlSVlJKYWt0Q1EwSlNRMnRoUjNoM1VXdHFUVEZNZDBaWFNua3dVVzlYU2tSVWFFcG1SVmhIUW10aFNtbGpiMHRUYnpGT2FtTTBUMVJ3UkZKRlZrZFNNR2hLVTJ4T1ZWWldXbGhYUm14aFdUSlNiRnB0Wkc5aFYzQjZaRWhXTW1RemFEVmxiMHRFYUVsWFIyZzBhVXBwY0V0VWJFcFhWMncxYVZwdGNVdHFjRXRYYlhBMmFYQnhja3Q2ZEV4WE1uUTNhVFYxYzB4RWVFMVlSM2c0YWtwNWRFeFVNVTVZVnpFNWFsb3lkVXhxTlU5WWJUVXJhbkEyZGt4Nk9WQllNamt2YWpVcmRpOWhRVUYzUkVGUlFVTkZVVTFTUVVRNFFUWkhVRmhWU0ZaaGRIZzJMME5sTVdWWFJGaE1hbU5OTVVwTWNtczJUV2RCTmpGeEsyUk1ZMnhqY2xvMmMyUmhhVEkxZDJOV1FTdDJVV3B5V0U4eVRuZGFOMEpZV1dNMGNIZERlVVJyVm5wVGVFVnJZa3RuYldZdk9XczlJajRLQ1R3dmFXMWhaMlUrQ2p3dmMzWm5QZz09In0sIm1lZGlhX2xpYnJhcnlfb3JpZ2luYWwiOnsidXJscyI6WyJndWxiYXJnLW5vbi1kZXZlbG9wX19fbWVkaWFfbGlicmFyeV9vcmlnaW5hbF8zOTlfMTgwLmpwZWciXSwiYmFzZTY0c3ZnIjoiZGF0YTppbWFnZVwvc3ZnK3htbDtiYXNlNjQsUENGRVQwTlVXVkJGSUhOMlp5QlFWVUpNU1VNZ0lpMHZMMWN6UXk4dlJGUkVJRk5XUnlBeExqRXZMMFZPSWlBaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdlIzSmhjR2hwWTNNdlUxWkhMekV1TVM5RVZFUXZjM1puTVRFdVpIUmtJajRLUEhOMlp5QjJaWEp6YVc5dVBTSXhMakVpSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh5TURBd0wzTjJaeUlnZUcxc2JuTTZlR3hwYm1zOUltaDBkSEE2THk5M2QzY3Vkek11YjNKbkx6RTVPVGt2ZUd4cGJtc2lJSGh0YkRwemNHRmpaVDBpY0hKbGMyVnlkbVVpSUhnOUlqQWlDaUI1UFNJd0lpQjJhV1YzUW05NFBTSXdJREFnTXprNUlERTRNQ0krQ2drOGFXMWhaMlVnZDJsa2RHZzlJak01T1NJZ2FHVnBaMmgwUFNJeE9EQWlJSGhzYVc1ck9taHlaV1k5SW1SaGRHRTZhVzFoWjJVdmFuQmxaenRpWVhObE5qUXNMemxxTHpSQlFWRlRhMXBLVW1kQlFrRlJSVUZaUVVKblFVRkVMeTluUVN0Uk1VcEdVVlpTVUZWcWIyZGFNbEYwWVc1Q2JGcDVRakpOVXpSM1NVTm9NV015YkhWYWVVSktVMnRqWjFOc1FrWlNlVUl5VDBSQmNFeERRbXRhVjFwb1pGZDRNRWxJUmpGWlYzaHdaRWhyU3k4NWMwRlJkMEZKUW1kWlNFSm5WVWxDZDJOSVExRnJTVU5uZDFWRVVYZE1RM2QzV2tWb1RWQkdRakJoU0hnMFpFZG9kMk5KUTFGMVNubEJhVXhEVFdOSVEyY3pTMU4zZDAxVVVUQk9Ramh1VDFRd05FMXFkM1ZOZWxGNUx6bHpRVkYzUlVwRFVXdE5RM2QzV1VSUk1GbE5hVVZqU1ZSSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYa3ZPRUZCUlZGblFVUm5RV2RCZDBWcFFVRkpVa0ZSVFZKQlppOUZRVUk0UVVGQlJVWkJVVVZDUVZGRlFrRkJRVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZSUVVGSlFrRjNUVU5DUVUxR1FsRlJSVUZCUVVKbVVVVkRRWGRCUlVWUlZWTkpWRVpDUW1oT1VsbFJZMmxqVWxGNVoxcEhhRU5EVGtOelkwVldWWFJJZDBwRVRtbGpiMGxLUTJoWldFZENhMkZLVTFsdVMwTnJjVTVFVlRKT2VtYzFUMnRPUlZKVldraFRSV3hMVlRGU1ZsWnNaRmxYVm5CcVdrZFdiVm95YUhCaGJrNHdaRmhhTTJWSWJEWm5ORk5HYUc5bFNXbFpjVk5yTlZOV2JIQmxXVzFhY1dsdk5sTnNjSEZsYjNGaGNYbHpOMU14ZEhKbE5IVmlja04zT0ZSR2VITm1TWGxqY2xNd09WUldNWFJtV1RKa2NtZzBkVkJyTldWaWJqWlBibkU0Wmt4Nk9WQllNamt2YWpVcmRpOUZRVUk0UWtGQlRVSkJVVVZDUVZGRlFrRlJSVUZCUVVGQlFVRkJRa0ZuVFVWQ1VWbElRMEZyUzBNdkwwVkJURlZTUVVGSlFrRm5VVVZCZDFGSVFsRlJSVUZCUlVOa2QwRkNRV2ROVWtKQlZXaE5VVmxUVVZaRlNGbFlSVlJKYWt0Q1EwSlNRMnRoUjNoM1VXdHFUVEZNZDBaWFNua3dVVzlYU2tSVWFFcG1SVmhIUW10aFNtbGpiMHRUYnpGT2FtTTBUMVJ3UkZKRlZrZFNNR2hLVTJ4T1ZWWldXbGhYUm14aFdUSlNiRnB0Wkc5aFYzQjZaRWhXTW1RemFEVmxiMHRFYUVsWFIyZzBhVXBwY0V0VWJFcFhWMncxYVZwdGNVdHFjRXRYYlhBMmFYQnhja3Q2ZEV4WE1uUTNhVFYxYzB4RWVFMVlSM2c0YWtwNWRFeFVNVTVZVnpFNWFsb3lkVXhxTlU5WWJUVXJhbkEyZGt4Nk9WQllNamt2YWpVcmRpOWhRVUYzUkVGUlFVTkZVVTFTUVVRNFFUWktUbVJSWkZaeE0waHlPRXB5ZVhOaE5XTmlhRzF3U21Sa2JsSnJRVWhYZEZoNmNHSnJjbXhpVUZacWNsVlhNMDlFVlVRMk4wTlBkR001V1ROS2JuTkdaR2g2YVc1QlRFbFBVbGhPVEVWVFVuTnhRMW92TDFvaVBnb0pQQzlwYldGblpUNEtQQzl6ZG1jKyJ9fSI7czoxMjoib3JkZXJfY29sdW1uIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNS0wNS0zMSAxMzo1NTo0NyI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNi0wNiAwMDowNDowNyI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTk6e3M6MjoiaWQiO2k6NjtzOjEwOiJtb2RlbF90eXBlIjtzOjE5OiJBcHBcTW9kZWxzXFByb3BlcnR5IjtzOjg6Im1vZGVsX2lkIjtpOjI7czo0OiJ1dWlkIjtzOjM2OiI1OWQ4MDg2Zi1kMGI5LTQyZmMtOTUxOC02ZmYzMDc3YjY0NGUiO3M6MTU6ImNvbGxlY3Rpb25fbmFtZSI7czoxNDoicHJvcGVydHlfaW1hZ2UiO3M6NDoibmFtZSI7czoxOToiZ3VsYmFyZyBub24gZGV2ZWxvcCI7czo5OiJmaWxlX25hbWUiO3M6MjQ6Imd1bGJhcmctbm9uLWRldmVsb3AuanBlZyI7czo5OiJtaW1lX3R5cGUiO3M6MTA6ImltYWdlL2pwZWciO3M6NDoiZGlzayI7czo2OiJwdWJsaWMiO3M6MTY6ImNvbnZlcnNpb25zX2Rpc2siO3M6NjoicHVibGljIjtzOjQ6InNpemUiO2k6NjYzOTtzOjEzOiJtYW5pcHVsYXRpb25zIjtzOjI6IltdIjtzOjE3OiJjdXN0b21fcHJvcGVydGllcyI7czoyOiJbXSI7czoyMToiZ2VuZXJhdGVkX2NvbnZlcnNpb25zIjtzOjE0OiJ7InRodW1iIjp0cnVlfSI7czoxNzoicmVzcG9uc2l2ZV9pbWFnZXMiO3M6MzkxODoieyJ0aHVtYiI6eyJ1cmxzIjpbImd1bGJhcmctbm9uLWRldmVsb3BfX190aHVtYl83OTZfMzYwLmpwZyIsImd1bGJhcmctbm9uLWRldmVsb3BfX190aHVtYl82NjVfMzAxLmpwZyIsImd1bGJhcmctbm9uLWRldmVsb3BfX190aHVtYl81NTdfMjUyLmpwZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdOemsySURNMk1DSStDZ2s4YVcxaFoyVWdkMmxrZEdnOUlqYzVOaUlnYUdWcFoyaDBQU0l6TmpBaUlIaHNhVzVyT21oeVpXWTlJbVJoZEdFNmFXMWhaMlV2YW5CbFp6dGlZWE5sTmpRc0x6bHFMelJCUVZGVGExcEtVbWRCUWtGUlJVRlpRVUpuUVVGRUx5OW5RU3RSTVVwR1VWWlNVRlZxYjJkYU1sRjBZVzVDYkZwNVFqSk5VelIzU1VOb01XTXliSFZhZVVKS1UydGpaMU5zUWtaU2VVSXlUMFJCY0V4RFFtdGFWMXBvWkZkNE1FbElSakZaVjNod1pFaHJTeTg1YzBGUmQwRkpRbWRaU0VKblZVbENkMk5JUTFGclNVTm5kMVZFVVhkTVEzZDNXa1ZvVFZCR1FqQmhTSGcwWkVkb2QyTkpRMUYxU25sQmFVeERUV05JUTJjelMxTjNkMDFVVVRCT1FqaHVUMVF3TkUxcWQzVk5lbEY1THpselFWRjNSVXBEVVd0TlEzZDNXVVJSTUZsTmFVVmpTVlJKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hrdk9FRkJSVkZuUVVSblFXZEJkMFZwUVVGSlVrRlJUVkpCWmk5RlFVSTRRVUZCUlVaQlVVVkNRVkZGUWtGQlFVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlJRVUZKUWtGM1RVTkNRVTFHUWxGUlJVRkJRVUptVVVWRFFYZEJSVVZSVlZOSlZFWkNRbWhPVWxsUlkybGpVbEY1WjFwSGFFTkRUa056WTBWV1ZYUklkMHBFVG1samIwbEtRMmhaV0VkQ2EyRktVMWx1UzBOcmNVNUVWVEpPZW1jMVQydE9SVkpWV2toVFJXeExWVEZTVmxac1pGbFhWbkJxV2tkV2JWb3lhSEJoYms0d1pGaGFNMlZJYkRabk5GTkdhRzlsU1dsWmNWTnJOVk5XYkhCbFdXMWFjV2x2TmxOc2NIRmxiM0ZoY1hsek4xTXhkSEpsTkhWaWNrTjNPRlJHZUhObVNYbGpjbE13T1ZSV01YUm1XVEprY21nMGRWQnJOV1ZpYmpaUGJuRTRaa3g2T1ZCWU1qa3ZhalVyZGk5RlFVSTRRa0ZCVFVKQlVVVkNRVkZGUWtGUlJVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlNRVUZKUWtGblVVVkJkMUZJUWxGUlJVRkJSVU5rZDBGQ1FXZE5Va0pCVldoTlVWbFRVVlpGU0ZsWVJWUkpha3RDUTBKU1EydGhSM2gzVVd0cVRURk1kMFpYU25rd1VXOVhTa1JVYUVwbVJWaEhRbXRoU21samIwdFRiekZPYW1NMFQxUndSRkpGVmtkU01HaEtVMnhPVlZaV1dsaFhSbXhoV1RKU2JGcHRaRzloVjNCNlpFaFdNbVF6YURWbGIwdEVhRWxYUjJnMGFVcHBjRXRVYkVwWFYydzFhVnB0Y1V0cWNFdFhiWEEyYVhCeGNrdDZkRXhYTW5RM2FUVjFjMHhFZUUxWVIzZzRha3A1ZEV4VU1VNVlWekU1YWxveWRVeHFOVTlZYlRVcmFuQTJka3g2T1ZCWU1qa3ZhalVyZGk5aFFVRjNSRUZSUVVORlVVMVNRVVE0UVRaSFVGaFZTRlpoZEhnMkwwTmxNV1ZYUkZoTWFtTk5NVXBNY21zMlRXZEJOakZ4SzJSTVkyeGpjbG8yYzJSaGFUSTFkMk5XUVN0MlVXcHlXRTh5VG5kYU4wSllXV00wY0hkRGVVUnJWbnBUZUVWcllrdG5iV1l2T1dzOUlqNEtDVHd2YVcxaFoyVStDand2YzNablBnPT0ifSwibWVkaWFfbGlicmFyeV9vcmlnaW5hbCI6eyJ1cmxzIjpbImd1bGJhcmctbm9uLWRldmVsb3BfX19tZWRpYV9saWJyYXJ5X29yaWdpbmFsXzM5OV8xODAuanBlZyJdLCJiYXNlNjRzdmciOiJkYXRhOmltYWdlXC9zdmcreG1sO2Jhc2U2NCxQQ0ZFVDBOVVdWQkZJSE4yWnlCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGTldSeUF4TGpFdkwwVk9JaUFpYUhSMGNEb3ZMM2QzZHk1M015NXZjbWN2UjNKaGNHaHBZM012VTFaSEx6RXVNUzlFVkVRdmMzWm5NVEV1WkhSa0lqNEtQSE4yWnlCMlpYSnphVzl1UFNJeExqRWlJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHlNREF3TDNOMlp5SWdlRzFzYm5NNmVHeHBibXM5SW1oMGRIQTZMeTkzZDNjdWR6TXViM0puTHpFNU9Ua3ZlR3hwYm1zaUlIaHRiRHB6Y0dGalpUMGljSEpsYzJWeWRtVWlJSGc5SWpBaUNpQjVQU0l3SWlCMmFXVjNRbTk0UFNJd0lEQWdNems1SURFNE1DSStDZ2s4YVcxaFoyVWdkMmxrZEdnOUlqTTVPU0lnYUdWcFoyaDBQU0l4T0RBaUlIaHNhVzVyT21oeVpXWTlJbVJoZEdFNmFXMWhaMlV2YW5CbFp6dGlZWE5sTmpRc0x6bHFMelJCUVZGVGExcEtVbWRCUWtGUlJVRlpRVUpuUVVGRUx5OW5RU3RSTVVwR1VWWlNVRlZxYjJkYU1sRjBZVzVDYkZwNVFqSk5VelIzU1VOb01XTXliSFZhZVVKS1UydGpaMU5zUWtaU2VVSXlUMFJCY0V4RFFtdGFWMXBvWkZkNE1FbElSakZaVjNod1pFaHJTeTg1YzBGUmQwRkpRbWRaU0VKblZVbENkMk5JUTFGclNVTm5kMVZFVVhkTVEzZDNXa1ZvVFZCR1FqQmhTSGcwWkVkb2QyTkpRMUYxU25sQmFVeERUV05JUTJjelMxTjNkMDFVVVRCT1FqaHVUMVF3TkUxcWQzVk5lbEY1THpselFWRjNSVXBEVVd0TlEzZDNXVVJSTUZsTmFVVmpTVlJKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hsTmFrbDVUV3BKZVUxcVNYbE5ha2w1VFdwSmVVMXFTWGxOYWtsNVRXcEplVTFxU1hrdk9FRkJSVkZuUVVSblFXZEJkMFZwUVVGSlVrRlJUVkpCWmk5RlFVSTRRVUZCUlVaQlVVVkNRVkZGUWtGQlFVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlJRVUZKUWtGM1RVTkNRVTFHUWxGUlJVRkJRVUptVVVWRFFYZEJSVVZSVlZOSlZFWkNRbWhPVWxsUlkybGpVbEY1WjFwSGFFTkRUa056WTBWV1ZYUklkMHBFVG1samIwbEtRMmhaV0VkQ2EyRktVMWx1UzBOcmNVNUVWVEpPZW1jMVQydE9SVkpWV2toVFJXeExWVEZTVmxac1pGbFhWbkJxV2tkV2JWb3lhSEJoYms0d1pGaGFNMlZJYkRabk5GTkdhRzlsU1dsWmNWTnJOVk5XYkhCbFdXMWFjV2x2TmxOc2NIRmxiM0ZoY1hsek4xTXhkSEpsTkhWaWNrTjNPRlJHZUhObVNYbGpjbE13T1ZSV01YUm1XVEprY21nMGRWQnJOV1ZpYmpaUGJuRTRaa3g2T1ZCWU1qa3ZhalVyZGk5RlFVSTRRa0ZCVFVKQlVVVkNRVkZGUWtGUlJVRkJRVUZCUVVGQlFrRm5UVVZDVVZsSVEwRnJTME12TDBWQlRGVlNRVUZKUWtGblVVVkJkMUZJUWxGUlJVRkJSVU5rZDBGQ1FXZE5Va0pCVldoTlVWbFRVVlpGU0ZsWVJWUkpha3RDUTBKU1EydGhSM2gzVVd0cVRURk1kMFpYU25rd1VXOVhTa1JVYUVwbVJWaEhRbXRoU21samIwdFRiekZPYW1NMFQxUndSRkpGVmtkU01HaEtVMnhPVlZaV1dsaFhSbXhoV1RKU2JGcHRaRzloVjNCNlpFaFdNbVF6YURWbGIwdEVhRWxYUjJnMGFVcHBjRXRVYkVwWFYydzFhVnB0Y1V0cWNFdFhiWEEyYVhCeGNrdDZkRXhYTW5RM2FUVjFjMHhFZUUxWVIzZzRha3A1ZEV4VU1VNVlWekU1YWxveWRVeHFOVTlZYlRVcmFuQTJka3g2T1ZCWU1qa3ZhalVyZGk5aFFVRjNSRUZSUVVORlVVMVNRVVE0UVRaS1RtUlJaRlp4TTBoeU9FcHllWE5oTldOaWFHMXdTbVJrYmxKclFVaFhkRmg2Y0dKcmNteGlVRlpxY2xWWE0wOUVWVVEyTjBOUGRHTTVXVE5LYm5OR1pHaDZhVzVCVEVsUFVsaE9URVZUVW5OeFExb3ZMMW9pUGdvSlBDOXBiV0ZuWlQ0S1BDOXpkbWMrIn19IjtzOjEyOiJvcmRlcl9jb2x1bW4iO2k6MTtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI1LTA1LTMxIDEzOjU1OjQ3IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI1LTA2LTA2IDAwOjA0OjA3IjtzOjEwOiJkZWxldGVkX2F0IjtOO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjQ6e3M6MTM6Im1hbmlwdWxhdGlvbnMiO3M6NToiYXJyYXkiO3M6MTc6ImN1c3RvbV9wcm9wZXJ0aWVzIjtzOjU6ImFycmF5IjtzOjIxOiJnZW5lcmF0ZWRfY29udmVyc2lvbnMiO3M6NToiYXJyYXkiO3M6MTc6InJlc3BvbnNpdmVfaW1hZ2VzIjtzOjU6ImFycmF5Ijt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjI6e2k6MDtzOjEyOiJvcmlnaW5hbF91cmwiO2k6MTtzOjExOiJwcmV2aWV3X3VybCI7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6Mjc6IgAqAHJlbGF0aW9uQXV0b2xvYWRDYWxsYmFjayI7TjtzOjI2OiIAKgByZWxhdGlvbkF1dG9sb2FkQ29udGV4dCI7TjtzOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czoxMzoidXNlc1VuaXF1ZUlkcyI7YjowO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTowOnt9czoxMDoiACoAZ3VhcmRlZCI7YTowOnt9czoxODoiACoAc3RyZWFtQ2h1bmtTaXplIjtpOjEwNDg1NzY7fX1zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxNDoiY29sbGVjdGlvbk5hbWUiO047czoxMzoiZm9ybUZpZWxkTmFtZSI7Tjt9czo3OiJzb2NpZXR5IjtOO31zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjI3OiIAKgByZWxhdGlvbkF1dG9sb2FkQ2FsbGJhY2siO047czoyNjoiACoAcmVsYXRpb25BdXRvbG9hZENvbnRleHQiO047czoxMDoidGltZXN0YW1wcyI7YjoxO3M6MTM6InVzZXNVbmlxdWVJZHMiO2I6MDtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMToiACoAZmlsbGFibGUiO2E6MzI6e2k6MDtzOjc6InVzZXJfaWQiO2k6MTtzOjEwOiJzb2NpZXR5X2lkIjtpOjI7czoxMzoic3ViX3NlY3Rvcl9pZCI7aTozO3M6NToidGl0bGUiO2k6NDtzOjQ6InNsdWciO2k6NTtzOjExOiJkZXNjcmlwdGlvbiI7aTo2O3M6ODoia2V5d29yZHMiO2k6NztzOjc6InB1cnBvc2UiO2k6ODtzOjEzOiJwcm9wZXJ0eV90eXBlIjtpOjk7czo5OiJwbG90X3NpemUiO2k6MTA7czoxNToicGxvdF9kaW1lbnNpb25zIjtpOjExO3M6NToicHJpY2UiO2k6MTI7czo0OiJyZW50IjtpOjEzO3M6OToicmVudF90eXBlIjtpOjE0O3M6NzoicGxvdF9ubyI7aToxNTtzOjY6InN0cmVldCI7aToxNjtzOjg6ImxvY2F0aW9uIjtpOjE3O3M6ODoibGF0aXR1ZGUiO2k6MTg7czo5OiJsb25naXR1ZGUiO2k6MTk7czo4OiJmZWF0dXJlcyI7aToyMDtzOjE3OiJuZWFyYnlfZmFjaWxpdGllcyI7aToyMTtzOjE2OiJpbnN0YWxsbWVudF9wbGFuIjtpOjIyO3M6MTI6ImJlc3Rfc2VsbGluZyI7aToyMztzOjEwOiJ0b2RheV9kZWFsIjtpOjI0O3M6ODoiYXBwcm92ZWQiO2k6MjU7czo2OiJzdGF0dXMiO2k6MjY7czo5OiJtYXBfZW1iZWQiO2k6Mjc7czoxMToidmlkZW9fZW1iZWQiO2k6Mjg7czoxNToic2hvcnRfdmlkZW9fdXJsIjtpOjI5O3M6MTA6ImV4dHJhX2RhdGEiO2k6MzA7czoxMDoiY3JlYXRlZF9ieSI7aTozMTtzOjU6InZpZXdzIjt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9czoxNjoiACoAZm9yY2VEZWxldGluZyI7YjowO319czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO30=	1752216102
laravel_cache_ef9c6f4a70463674911495668306eab8fc67e30e	i:4;	1752216102
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: cities; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.cities (id, name, slug, status, created_at, updated_at, deleted_at) FROM stdin;
1	Faisalabad	faisalabad	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
2	Rawalpindi	rawalpindi	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
3	Islamabad	islamabad	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
4	Lahore	lahore	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
5	Multan	multan	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
6	Bahawalpur	bahawalpur	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
7	Karachi	karachi	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
9	Peshawar	peshawar	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
10	Quetta	quetta	enabled	2025-05-28 14:21:32	2025-05-28 14:21:32	\N
8	Attock	attock	enabled	2025-05-28 14:21:32	2025-06-21 18:29:13	2025-06-21 18:29:13
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
36	default	{"uuid":"3a588710-800b-43e5-8de4-7540f1d90012","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:11;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1749168247,"delay":null}	0	\N	1749168247	1749168247
37	default	{"uuid":"c787d52c-fdb8-4302-949e-21b06f0a3ecb","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:9;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1749168247,"delay":null}	0	\N	1749168247	1749168247
38	default	{"uuid":"d8b2df9b-6d8d-4591-9cb4-c15441e15034","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:6;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1749168247,"delay":null}	0	\N	1749168247	1749168247
39	default	{"uuid":"c56cfd47-a90f-4644-af15-e1ea4f2533a2","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:8;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1749168248,"delay":null}	0	\N	1749168248	1749168248
40	default	{"uuid":"c5659f9e-22a8-411c-8dc4-06bc96bd61ed","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:10;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1749168248,"delay":null}	0	\N	1749168248	1749168248
41	default	{"uuid":"d790d2c2-fb76-4174-a11e-e20e1de44d5e","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:7;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1749168248,"delay":null}	0	\N	1749168248	1749168248
42	default	{"uuid":"ac2c0660-5faa-466a-8415-0180c72542df","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":2:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:12;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";}"},"createdAt":1750531036,"delay":null}	0	\N	1750531036	1750531036
43	default	{"uuid":"64c95345-b126-42f8-bd9c-e906c926c988","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:7;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1750624838,"delay":null}	0	\N	1750624838	1750624838
44	default	{"uuid":"565100d2-446c-4b91-a8bc-fc7af28dae59","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:9;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1750624839,"delay":null}	0	\N	1750624839	1750624839
45	default	{"uuid":"a920865c-3de3-42a9-8bbf-dbfa864ff32d","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:6;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1750624839,"delay":null}	0	\N	1750624839	1750624839
46	default	{"uuid":"4b6f2b32-7a21-43bb-901f-dc27f09d89eb","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:8;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1750624839,"delay":null}	0	\N	1750624839	1750624839
47	default	{"uuid":"ea5fee63-c6f6-49fe-bbfd-2e3f1ea1d515","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:10;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1750624839,"delay":null}	0	\N	1750624839	1750624839
48	default	{"uuid":"7e4f95e1-c9f8-4a3c-8984-a220fcff60e7","displayName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob","command":"O:69:\\"Spatie\\\\MediaLibrary\\\\ResponsiveImages\\\\Jobs\\\\GenerateResponsiveImagesJob\\":4:{s:8:\\"\\u0000*\\u0000media\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:49:\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\";s:2:\\"id\\";i:11;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"pgsql\\";s:15:\\"collectionClass\\";N;}s:10:\\"connection\\";s:8:\\"database\\";s:5:\\"queue\\";s:0:\\"\\";s:11:\\"afterCommit\\";b:1;}"},"createdAt":1750624839,"delay":null}	0	\N	1750624839	1750624839
\.


--
-- Data for Name: media; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.media (id, model_type, model_id, uuid, collection_name, name, file_name, mime_type, disk, conversions_disk, size, manipulations, custom_properties, generated_conversions, responsive_images, order_column, created_at, updated_at, deleted_at) FROM stdin;
2	App\\Models\\Society	1	0e856e87-3392-40a6-a7d3-b00cd730f515	banner	bAHRIA-ENCLAVE-map	20250531-bY8n7J.webp	image/webp	public	public	57802	[]	[]	{"thumb":true}	{"media_library_original":{"urls":["20250531-bY8n7J___media_library_original_564_327.webp","20250531-bY8n7J___media_library_original_471_273.webp","20250531-bY8n7J___media_library_original_394_228.webp","20250531-bY8n7J___media_library_original_330_191.webp","20250531-bY8n7J___media_library_original_276_160.webp"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNTY0IDMyNyI+Cgk8aW1hZ2Ugd2lkdGg9IjU2NCIgaGVpZ2h0PSIzMjciIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUV3QWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTljMUtJU29BVHRBckpTekRraFhPSzJyeTNta1hnNUZVa3RKbzJBQXJtcXQ4Mnh2Q3RPRWJKbFA3TUZKQlk1clFzWFNHRXFPVFJjV1VxeDcrcHFPemdrVWt2UkRtdVRPdk9mdXRsMFNQL2VOU2hpZTlGRmJJaGp5eEs0SnFyS1NING9vcHNTUC8yUT09Ij4KCTwvaW1hZ2U+Cjwvc3ZnPg=="}}	2	2025-05-31 12:58:02	2025-06-05 23:57:23	\N
3	App\\Models\\SubSector	5	fcec01e6-d450-4f1e-9d0d-ac52f8e41624	sub_sector_image	024e9b19-6959-454f-9085-7d4ba6fe7c13	20250531-5qxEO4.jpg	image/jpeg	public	public	162641	[]	[]	{"thumb":true}	{"media_library_original":{"urls":["20250531-5qxEO4___media_library_original_960_1280.jpg","20250531-5qxEO4___media_library_original_803_1071.jpg","20250531-5qxEO4___media_library_original_672_896.jpg","20250531-5qxEO4___media_library_original_562_749.jpg","20250531-5qxEO4___media_library_original_470_627.jpg","20250531-5qxEO4___media_library_original_393_524.jpg","20250531-5qxEO4___media_library_original_329_439.jpg","20250531-5qxEO4___media_library_original_275_367.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgOTYwIDEyODAiPgoJPGltYWdlIHdpZHRoPSI5NjAiIGhlaWdodD0iMTI4MCIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBK1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPREFwTENCa1pXWmhkV3gwSUhGMVlXeHBkSGtLLzlzQVF3QUlCZ1lIQmdVSUJ3Y0hDUWtJQ2d3VURRd0xDd3daRWhNUEZCMGFIeDRkR2h3Y0lDUXVKeUFpTENNY0hDZzNLU3d3TVRRME5COG5PVDA0TWp3dU16UXkvOXNBUXdFSkNRa01Dd3dZRFEwWU1pRWNJVEl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeS84QUFFUWdBS3dBZ0F3RWlBQUlSQVFNUkFmL0VBQjhBQUFFRkFRRUJBUUVCQUFBQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVFBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNSt2L0VBQjhCQUFNQkFRRUJBUUVCQVFFQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVJBQUlCQWdRRUF3UUhCUVFFQUFFQ2R3QUJBZ01SQkFVaE1RWVNRVkVIWVhFVElqS0JDQlJDa2FHeHdRa2pNMUx3RldKeTBRb1dKRFRoSmZFWEdCa2FKaWNvS1NvMU5qYzRPVHBEUkVWR1IwaEpTbE5VVlZaWFdGbGFZMlJsWm1kb2FXcHpkSFYyZDNoNWVvS0RoSVdHaDRpSmlwS1RsSldXbDVpWm1xS2pwS1dtcDZpcHFyS3p0TFcydDdpNXVzTER4TVhHeDhqSnl0TFQxTlhXMTlqWjJ1TGo1T1htNStqcDZ2THo5UFgyOS9qNSt2L2FBQXdEQVFBQ0VRTVJBRDhBc1hLTExJQW80elMzQ3VWV0VkTzlXSndJRHVLOFZDazBjNUlYN3hyejFGSyt1N092MmwwbjJSRFBPc0VBaFE4MUZieU8wTEtCMXFPOWdGbVRMTzNGWTExNGlTRUZZUitOTnFVbmRFSnBibmN6UnJNQXI5S2pudExlelpIVHFhb3phZzd6K1hHcHptcnMybTNkM0FyTXhYaXVpRkRuYnNqQ1ZaUVNUT1I4YlhqRkl3cmNlMWNSTlB4eFhwV29hQ0p3Rm1PN0ZZOXg0WmdBNFdyVUhIY09aTmFIU3hPZ3VQTXdPdGRHbXBMTkFxcmdFVng2RTdSelYvVFdienNaTmRkTjJPYXJHNk5LL1pUaGdSbXNlUmdldFQzekh6aU0xVG4vQU5XS2lidXlxYXNqLzlrPSI+Cgk8L2ltYWdlPgo8L3N2Zz4="}}	1	2025-05-31 13:27:29	2025-06-05 23:57:24	\N
7	App\\Models\\Property	3	6aec1e61-226d-4999-b348-affa7f54e00d	property_image	45a06263-90a8-4fa1-8a2d-49619ff96db5	45a06263-90a8-4fa1-8a2d-49619ff96db5.jpg	image/jpeg	public	public	175475	[]	[]	{"thumb":true}	{"thumb":{"urls":["45a06263-90a8-4fa1-8a2d-49619ff96db5___thumb_270_360.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___thumb_225_300.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___thumb_189_252.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMjcwIDM2MCI+Cgk8aW1hZ2Ugd2lkdGg9IjI3MCIgaGVpZ2h0PSIzNjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUt3QWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTVIeDdmM1Y1TDVDUnRzOWNWZ2FOb0VxNG1sVWdWN0RxT21Xb3QvTWxpVTQ3a1ZTRmhaZlpESWpydHgwOUs1VldkN0pHamducTJjc2xyR0l3V1B6TDBvdW5FdXdkaFdtZFBMeWZMeXA2VW8wZVF0a0FZSHJUNVVuZVdvN3Uxa2RQNHFtRVdpUHRQellyenpUYjJkNFdSeTJNMXErSWRVbVhNVXh6anRXTGI2dENzV0NvV25CdExRaWExT3owaTRXUXFzc1IyTDN4V0o0cDFtYTJ1VEhha3FsYm5oelVVdklOaUlDUjN4V2I0azBLVzhtWjFHTTFvNTZXYUVvcTk3bVY0aUJudkdPMDRybTU3WW1SRnhnRTEyM2lGVkFCQUFOYzI0QktaSGVzSXV6T2x4VW8zUFJmQ3VuUldPbkk0R1dZVmZ2aXJ0bkZNMGovQUpCY1grN1JjOUs2WVR2Q3pPT1VMU3VmLzlrPSI+Cgk8L2ltYWdlPgo8L3N2Zz4="},"media_library_original":{"urls":["45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_960_1280.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_803_1071.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_672_896.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_562_749.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_470_627.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_393_524.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_329_439.jpg","45a06263-90a8-4fa1-8a2d-49619ff96db5___media_library_original_275_367.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgOTYwIDEyODAiPgoJPGltYWdlIHdpZHRoPSI5NjAiIGhlaWdodD0iMTI4MCIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBK1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPREFwTENCa1pXWmhkV3gwSUhGMVlXeHBkSGtLLzlzQVF3QUlCZ1lIQmdVSUJ3Y0hDUWtJQ2d3VURRd0xDd3daRWhNUEZCMGFIeDRkR2h3Y0lDUXVKeUFpTENNY0hDZzNLU3d3TVRRME5COG5PVDA0TWp3dU16UXkvOXNBUXdFSkNRa01Dd3dZRFEwWU1pRWNJVEl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeS84QUFFUWdBS3dBZ0F3RWlBQUlSQVFNUkFmL0VBQjhBQUFFRkFRRUJBUUVCQUFBQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVFBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNSt2L0VBQjhCQUFNQkFRRUJBUUVCQVFFQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVJBQUlCQWdRRUF3UUhCUVFFQUFFQ2R3QUJBZ01SQkFVaE1RWVNRVkVIWVhFVElqS0JDQlJDa2FHeHdRa2pNMUx3RldKeTBRb1dKRFRoSmZFWEdCa2FKaWNvS1NvMU5qYzRPVHBEUkVWR1IwaEpTbE5VVlZaWFdGbGFZMlJsWm1kb2FXcHpkSFYyZDNoNWVvS0RoSVdHaDRpSmlwS1RsSldXbDVpWm1xS2pwS1dtcDZpcHFyS3p0TFcydDdpNXVzTER4TVhHeDhqSnl0TFQxTlhXMTlqWjJ1TGo1T1htNStqcDZ2THo5UFgyOS9qNSt2L2FBQXdEQVFBQ0VRTVJBRDhBNUh4N2YzVjVMNUNSdHM5Y1ZnYU5vRXE0bWxVZ1Y3RHFPbVdvdC9NbGlVNDdrVlNGaFpDME1pT3UzSFQwcmxWWjNza2E4aWVyWnl5V3NZaUJZL012U2k2Y1M3QjJGYVpzQzhueThxZWxPR2p5RnR3QXdQV255cE84dFF1N1dXaDAzaXVaWXRFZmFmbXhYbmVtM3M3eE1qbHNaclc4UTZwTU14VEhPTzFZdHZxMEtSWUtoYUlOcGFFVFdwMmVrWEN5RlZsaWJZbzYxaWVLTlptdDdreDJwS29LM1BEbW94M2tHeEV5UjN4V2I0azBPYTdtTG9NWnJWMUhhelFsRlh2Y3l2RVFNMTR4eHhYTnpXeGFSRnhnRTEyM2lGRkFCQUdhNXR3Q1V5TzljOFc0czZuRlNqYzlHOEs2ZEZZNmNqZ0Fzd3EvZkZYYk9LajBmL2tGeGY3dEYxMHJxaE51Tm1jVW9KU3VmLy9aIj4KCTwvaW1hZ2U+Cjwvc3ZnPg=="}}	1	2025-05-31 14:01:14	2025-06-06 00:04:08	\N
4	App\\Models\\SubSector	6	c21d7436-0272-4445-a5c0-6fda04ad3422	sub_sector_image	3cdcc513-149b-4fce-827c-395ce8f2e433	20250531-mGxgRL.jpg	image/jpeg	public	public	9149	[]	[]	{"thumb":true}	{"media_library_original":{"urls":["20250531-mGxgRL___media_library_original_299_169.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMjk5IDE2OSI+Cgk8aW1hZ2Ugd2lkdGg9IjI5OSIgaGVpZ2h0PSIxNjkiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUVnQWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTZtM250VzU4MVIrTlE2anIxcHBxYnZNVmo3R3VaU3ltRUJVT2MvV3N5Ync5ZFhESGZJeEh1YXVXS21acWltZDFvdml5MnZtSVpndjFOZEl1cjJRSCt2VDg2OGdpOE1YVWYrcWtaZnBXamE2QmVnL3ZKM0krdFRIRXo2amRGR3hGVnBPdEZGWk0xUlpRRDBxZFFLS0tTS1AvMlE9PSI+Cgk8L2ltYWdlPgo8L3N2Zz4="}}	1	2025-05-31 13:28:47	2025-06-05 23:57:24	\N
9	App\\Models\\Property	5	83b5bdde-0d8c-4e74-8a87-21fca43ddb8d	property_image	2d9aff24-b962-41ee-bde2-46495d3e00a4	2d9aff24-b962-41ee-bde2-46495d3e00a4.jpg	image/jpeg	public	public	150553	[]	[]	{"thumb":true}	{"thumb":{"urls":["2d9aff24-b962-41ee-bde2-46495d3e00a4___thumb_480_360.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___thumb_401_301.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___thumb_336_252.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___thumb_281_211.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNDgwIDM2MCI+Cgk8aW1hZ2Ugd2lkdGg9IjQ4MCIgaGVpZ2h0PSIzNjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUdBQWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTZHNWUxMWl6a2pqYnFPbGNCUG9jdHJOSU5ueWc4R3VpaFNYVDFrdVA3b3ppc0RWUEZjbHhhU0o1VzF1bWNWei9BQjZsL0RvVUk5TmtlZmV3eldySDRlUzd3SFlWVTBYVkpUYWJYaEw4OWNWcmEzZngyK2krWmJaU2J2VzNzK2JWc2puNWVocGFIYjNHcG9aN25pSTlxMGJyd2xaNmphc2tNUVZ2V2lpbFJTdllkWFJFT25lRy93Q3gwTWJBTVBlcVBpYUMxWFRISmpBTkZGWVRrNDFySTBTVHA2bi8yUT09Ij4KCTwvaW1hZ2U+Cjwvc3ZnPg=="},"media_library_original":{"urls":["2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_1280_960.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_1070_803.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_895_671.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_749_562.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_627_470.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_524_393.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_439_329.jpg","2d9aff24-b962-41ee-bde2-46495d3e00a4___media_library_original_367_275.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMTI4MCA5NjAiPgoJPGltYWdlIHdpZHRoPSIxMjgwIiBoZWlnaHQ9Ijk2MCIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBK1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPREFwTENCa1pXWmhkV3gwSUhGMVlXeHBkSGtLLzlzQVF3QUlCZ1lIQmdVSUJ3Y0hDUWtJQ2d3VURRd0xDd3daRWhNUEZCMGFIeDRkR2h3Y0lDUXVKeUFpTENNY0hDZzNLU3d3TVRRME5COG5PVDA0TWp3dU16UXkvOXNBUXdFSkNRa01Dd3dZRFEwWU1pRWNJVEl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeS84QUFFUWdBR0FBZ0F3RWlBQUlSQVFNUkFmL0VBQjhBQUFFRkFRRUJBUUVCQUFBQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVFBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNSt2L0VBQjhCQUFNQkFRRUJBUUVCQVFFQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVJBQUlCQWdRRUF3UUhCUVFFQUFFQ2R3QUJBZ01SQkFVaE1RWVNRVkVIWVhFVElqS0JDQlJDa2FHeHdRa2pNMUx3RldKeTBRb1dKRFRoSmZFWEdCa2FKaWNvS1NvMU5qYzRPVHBEUkVWR1IwaEpTbE5VVlZaWFdGbGFZMlJsWm1kb2FXcHpkSFYyZDNoNWVvS0RoSVdHaDRpSmlwS1RsSldXbDVpWm1xS2pwS1dtcDZpcHFyS3p0TFcydDdpNXVzTER4TVhHeDhqSnl0TFQxTlhXMTlqWjJ1TGo1T1htNStqcDZ2THo5UFgyOS9qNSt2L2FBQXdEQVFBQ0VRTVJBRDhBNkc1ZTExaXprampZY2pwWEF6NkhMYXpTZklkb1BCcm9ZVWwwOVpMais2TTRyQTFUeFpMY1dzaWVWdGJwbkZjL3g2bC9Eb1VZOU5rZWZld3pXcEg0ZVM3d0hZVlQwWFZKV3ROcndsOG5rNHJYMXUvaXQ5Rjh5MnlrMWJleTV0V3llZmw2R2xvVnRjYW1obnV1SWoyclN1dkNObnFOcXlReGhXOWNVVVVxS1Y3QlYwUkJwdmhyK3gwTWJBTVBjVlI4VHdXcTZheE1ZQm9vckNjbkd0WkdpU2RQVS8vWiI+Cgk8L2ltYWdlPgo8L3N2Zz4="}}	1	2025-05-31 14:09:11	2025-06-06 00:04:07	\N
6	App\\Models\\Property	2	59d8086f-d0b9-42fc-9518-6ff3077b644e	property_image	gulbarg non develop	gulbarg-non-develop.jpeg	image/jpeg	public	public	6639	[]	[]	{"thumb":true}	{"thumb":{"urls":["gulbarg-non-develop___thumb_796_360.jpg","gulbarg-non-develop___thumb_665_301.jpg","gulbarg-non-develop___thumb_557_252.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNzk2IDM2MCI+Cgk8aW1hZ2Ugd2lkdGg9Ijc5NiIgaGVpZ2h0PSIzNjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQURnQWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTZHUFhVSFZhdHg2L0NlMWVXRFhMamNNMUpMcms2TWdBNjFxK2RMY2xjclo2c2RhaTI1d2NWQSt2UWpyWE8yTndaN0JYWWM0cHdDeURrVnpTeEVrYktnbWYvOWs9Ij4KCTwvaW1hZ2U+Cjwvc3ZnPg=="},"media_library_original":{"urls":["gulbarg-non-develop___media_library_original_399_180.jpeg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMzk5IDE4MCI+Cgk8aW1hZ2Ugd2lkdGg9IjM5OSIgaGVpZ2h0PSIxODAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQURnQWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTZKTmRRZFZxM0hyOEpyeXNhNWNiaG1wSmRkblJrQUhXdFh6cGJrcmxiUFZqclVXM09EVUQ2N0NPdGM5WTNKbnNGZGh6aW5BTElPUlhOTEVTUnNxQ1ovL1oiPgoJPC9pbWFnZT4KPC9zdmc+"}}	1	2025-05-31 13:55:47	2025-06-06 00:04:07	\N
12	App\\Models\\Society	2	535ab3c5-4441-4439-83b8-3f19686f324f	banner	gulberg_farmhouse	20250621-ENNXKE.webp	image/webp	public	public	132356	[]	[]	{"thumb":true}	[]	1	2025-06-21 18:37:16	2025-06-22 20:40:39	\N
1	App\\Models\\Society	1	3d8424aa-2a21-4ebd-851c-52238d6682fb	society_image	bAHRIA ENCLAVE image	20250531-MvgGF7.webp	image/webp	public	public	47060	[]	[]	{"thumb":true}	{"media_library_original":{"urls":["20250531-MvgGF7___media_library_original_564_327.webp","20250531-MvgGF7___media_library_original_471_273.webp","20250531-MvgGF7___media_library_original_394_228.webp","20250531-MvgGF7___media_library_original_330_191.webp","20250531-MvgGF7___media_library_original_276_160.webp"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNTY0IDMyNyI+Cgk8aW1hZ2Ugd2lkdGg9IjU2NCIgaGVpZ2h0PSIzMjciIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUV3QWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTlHbnRnZ0pERDZWbS9aekl4NHJPdVBGRUJHUm5OWTdlTVRGY1lFWkl6Vjg5YStpRDJNV3JNN0JMQUt1VDFxTmJUekpDcFd1ZFh4ZTg3WUtFRHNha2s4V2VUQ083MXB6NGh0YUVMRHdTWnowaXJ2UEZRVFJwak8wVVVWNUtsSzI1ME1rdGxCUThWSE1vSjZVVVY2V0hrK1JhaWtmLzJRPT0iPgoJPC9pbWFnZT4KPC9zdmc+"}}	1	2025-05-31 12:58:02	2025-06-05 23:57:23	\N
5	App\\Models\\SubSector	7	b637a548-69af-4536-9a65-b87834b80cb1	sub_sector_image	5f908409-cdc0-45b5-8199-b1d3adc1762d	20250531-cQI6Rt.jpg	image/jpeg	public	public	37362	[]	[]	{"thumb":true}	{"media_library_original":{"urls":["20250531-cQI6Rt___media_library_original_720_960.jpg","20250531-cQI6Rt___media_library_original_602_803.jpg","20250531-cQI6Rt___media_library_original_503_671.jpg","20250531-cQI6Rt___media_library_original_421_561.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNzIwIDk2MCI+Cgk8aW1hZ2Ugd2lkdGg9IjcyMCIgaGVpZ2h0PSI5NjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUt3QWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTZiN1h0aFlrODRyRnVTdytjRE9UVWp1d2p4VjZ6Z1NhSERZelJVMnNnVDdrV252dGp5YWgxSW1aZmw2MVpsakVEYlJVRERORWRnWXlWZUt5Ymp4SEhwcysxbTZWc3pENVdQdFhrdml5WmhxTEFNY1ZNbVZDTnowMnoxVWFtUE5YcFYvcUs1UHdLL21hUzJlU0s2ZFhweFlwS3pGdUF4dG1LOWNWNTNxbmh1ODFLOWFSVk9LOUprLzFCcDl0R25sajVSVXNxTHNjejRTMGlmUzdhU09RSG10c0RrMXR4b29oYkNqcFdNMytzYjYwNGlrZi85az0iPgoJPC9pbWFnZT4KPC9zdmc+"}}	1	2025-05-31 13:33:05	2025-06-05 23:57:24	\N
8	App\\Models\\Property	4	a00d7756-31ca-4129-8598-5c8bbcb91b95	property_image	5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c	5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c.jpg	image/jpeg	public	public	39376	[]	[]	{"thumb":true}	{"thumb":{"urls":["5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___thumb_480_360.jpg","5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___thumb_401_301.jpg","5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___thumb_336_252.jpg","5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___thumb_281_211.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNDgwIDM2MCI+Cgk8aW1hZ2Ugd2lkdGg9IjQ4MCIgaGVpZ2h0PSIzNjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUdBQWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTRXOGt4ZHhzdzZHdTgwYUFYbGdKQjJGWmVxYWRZU29XSkNrVmY4T1h5MmtZalVia0ZTM29KSm1wREcxcTVseGpGVkp0UlM0bUl6azFvM2QxSGNxUWd3TVZtVzBVVnM3TjVlU2FWeDI2bm1yNmpjWHR3cXM1NVBTdlVQRGVoaVN4UXNlU0tLS2JBMTMwTXhTRGFjanZTM09sTEdtVjRORkZSY1ovLzlrPSI+Cgk8L2ltYWdlPgo8L3N2Zz4="},"media_library_original":{"urls":["5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___media_library_original_720_540.jpg","5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___media_library_original_602_452.jpg","5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___media_library_original_504_378.jpg","5eefcbb7-8ffb-42fb-8ae9-a1a7cdc7ab0c___media_library_original_421_316.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNzIwIDU0MCI+Cgk8aW1hZ2Ugd2lkdGg9IjcyMCIgaGVpZ2h0PSI1NDAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUdBQWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTRXOWt4ZHhzdzZHdTkwV0FYbGdKQjJGWldxNmRZU29XSkNrVmY4T1h5MmtmbHFOeUNwYnVoSk0xSVkydFg4M0dNVlVtMUJMaVlnSEpyUnZMcU81SHlEQXgwck10b283ZDJieThrMU54MjZubXI2amNYczZxem5rOUs5UThOYUdKTEZDeDVJb29xbUJzU2FHWXBCdE9SM291ZEtXTk55OEdpaW91TkgvLzJRPT0iPgoJPC9pbWFnZT4KPC9zdmc+"}}	1	2025-05-31 14:05:06	2025-06-06 00:04:08	\N
10	App\\Models\\Property	6	0d254481-ae76-4110-bd3a-4020a72fe3a7	property_image	64c46fb6-a358-439e-9c17-343d08808290	64c46fb6-a358-439e-9c17-343d08808290.jpg	image/jpeg	public	public	245595	[]	[]	{"thumb":true}	{"thumb":{"urls":["64c46fb6-a358-439e-9c17-343d08808290___thumb_270_360.jpg","64c46fb6-a358-439e-9c17-343d08808290___thumb_225_300.jpg","64c46fb6-a358-439e-9c17-343d08808290___thumb_189_252.jpg","64c46fb6-a358-439e-9c17-343d08808290___thumb_158_211.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMjcwIDM2MCI+Cgk8aW1hZ2Ugd2lkdGg9IjI3MCIgaGVpZ2h0PSIzNjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUt3QWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QThZL3NPKzdSR2c2UGVKeVlqK1Zlb3hScnR6dEZaMS9Pc1JQeURGT2hGVllxVFprOFJUNXVXR3A1N05wc3lxTUljMGtOcE5HMldpWS9oWGJXc2tFODN6S0szN2Ezc25YQmpVL2hXa3NKWGhMbGEwTlZWcFMyZXBGUGRwRmFsbDYxeTl6cURUVFlQSXJwYnZUZDlxOHF2Z1lybERFSTVUa1o1cnY0ZnkxT2c1dGN6UElwNGI2cEswbnIzTlMwV0ZrM0g1VDYxdDZTRmVVcXB5SzUrM2pOeW9qSHludFhSYURaVFdjLzd3NUJya3pHYndsZHlsb3VpTkhpRW0yNUdaRnFYbTJvalpzRHZWWVFXNWxCTWd4bXNOWGJ5K3BxSXlQajd4b3dXWllqRFFjS2IwWjZOU2xDcTd6V3gzangyUnMxTnZqekFPb3FtZFlsdFZBYk9SV1hwVHNVR1dOYkpoamtIem9EOWE4ckdUbFgvaU81RlhDVXFyVGEyUC9aIj4KCTwvaW1hZ2U+Cjwvc3ZnPg=="},"media_library_original":{"urls":["64c46fb6-a358-439e-9c17-343d08808290___media_library_original_960_1280.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_803_1071.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_672_896.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_562_749.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_470_627.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_393_524.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_329_439.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_275_367.jpg","64c46fb6-a358-439e-9c17-343d08808290___media_library_original_230_307.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgOTYwIDEyODAiPgoJPGltYWdlIHdpZHRoPSI5NjAiIGhlaWdodD0iMTI4MCIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBK1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPREFwTENCa1pXWmhkV3gwSUhGMVlXeHBkSGtLLzlzQVF3QUlCZ1lIQmdVSUJ3Y0hDUWtJQ2d3VURRd0xDd3daRWhNUEZCMGFIeDRkR2h3Y0lDUXVKeUFpTENNY0hDZzNLU3d3TVRRME5COG5PVDA0TWp3dU16UXkvOXNBUXdFSkNRa01Dd3dZRFEwWU1pRWNJVEl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeS84QUFFUWdBS3dBZ0F3RWlBQUlSQVFNUkFmL0VBQjhBQUFFRkFRRUJBUUVCQUFBQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVFBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNSt2L0VBQjhCQUFNQkFRRUJBUUVCQVFFQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVJBQUlCQWdRRUF3UUhCUVFFQUFFQ2R3QUJBZ01SQkFVaE1RWVNRVkVIWVhFVElqS0JDQlJDa2FHeHdRa2pNMUx3RldKeTBRb1dKRFRoSmZFWEdCa2FKaWNvS1NvMU5qYzRPVHBEUkVWR1IwaEpTbE5VVlZaWFdGbGFZMlJsWm1kb2FXcHpkSFYyZDNoNWVvS0RoSVdHaDRpSmlwS1RsSldXbDVpWm1xS2pwS1dtcDZpcHFyS3p0TFcydDdpNXVzTER4TVhHeDhqSnl0TFQxTlhXMTlqWjJ1TGo1T1htNStqcDZ2THo5UFgyOS9qNSt2L2FBQXdEQVFBQ0VRTVJBRDhBOFkvc1MrN1JHZzZQZUp5WWorVmVvd3hydHp0RloxL09zUlB5REZGQmUxaXBObVR4RlBtNVlhbm5zdW16S293aHpUWWJTYU5zdEUzNVYyOXJKQlBOaGxGYjlyYjJUcmhvMVA0VnBMQ1lpRXVWclExVmFqTFo2a005MmtWcVN2V3VYdWRRYWFiQjVGZExkYVlIdFhsVjhERmNxWWhIS2NqUE5laHc5bHFkQnphNW1lUFN3MzFTVnB2WHVhbG9zTEp1UHluMXJiMGtLOGhWVGtWejBFWnVWRVkrVTlxNkxRTEthem4vQUhweXBya3pLYndkZHlsb3VpTkhpRW0yNUdiRnFYbTJvalpzQTlhcmlDM01vSmtHTTFoQjJFWFUxSDVqNCs4YU1GbVdJdzBIQ205RDBxbEtGVjNtanUzanNqWnFiZkhtQWRSVkU2eExhcmhzNUZadWxPeFFaWTFzTkRISVBtUUg2MTVXTWxLdi9FZHpPcmhLVlZwdGJILy8yUT09Ij4KCTwvaW1hZ2U+Cjwvc3ZnPg=="}}	1	2025-05-31 14:19:20	2025-06-06 00:04:08	\N
11	App\\Models\\Property	7	54220e8d-f99e-4fd5-9585-4c636e0095b3	property_image	bb46cc9f-2449-4bbc-ad22-0cba6de96d2f	bb46cc9f-2449-4bbc-ad22-0cba6de96d2f.jpg	image/jpeg	public	public	157205	[]	[]	{"thumb":true}	{"thumb":{"urls":["bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___thumb_270_360.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___thumb_225_300.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___thumb_189_252.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMjcwIDM2MCI+Cgk8aW1hZ2Ugd2lkdGg9IjI3MCIgaGVpZ2h0PSIzNjAiIHhsaW5rOmhyZWY9ImRhdGE6aW1hZ2UvanBlZztiYXNlNjQsLzlqLzRBQVFTa1pKUmdBQkFRRUFZQUJnQUFELy9nQStRMUpGUVZSUFVqb2daMlF0YW5CbFp5QjJNUzR3SUNoMWMybHVaeUJKU2tjZ1NsQkZSeUIyT0RBcExDQmtaV1poZFd4MElIRjFZV3hwZEhrSy85c0FRd0FJQmdZSEJnVUlCd2NIQ1FrSUNnd1VEUXdMQ3d3WkVoTVBGQjBhSHg0ZEdod2NJQ1F1SnlBaUxDTWNIQ2czS1N3d01UUTBOQjhuT1QwNE1qd3VNelF5LzlzQVF3RUpDUWtNQ3d3WURRMFlNaUVjSVRJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXkvOEFBRVFnQUt3QWdBd0VpQUFJUkFRTVJBZi9FQUI4QUFBRUZBUUVCQVFFQkFBQUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVRQUFJQkF3TUNCQU1GQlFRRUFBQUJmUUVDQXdBRUVRVVNJVEZCQmhOUllRY2ljUlF5Z1pHaENDTkNzY0VWVXRId0pETmljb0lKQ2hZWEdCa2FKU1luS0NrcU5EVTJOemc1T2tORVJVWkhTRWxLVTFSVlZsZFlXVnBqWkdWbVoyaHBhbk4wZFhaM2VIbDZnNFNGaG9lSWlZcVNrNVNWbHBlWW1acWlvNlNscHFlb3FhcXlzN1MxdHJlNHVickN3OFRGeHNmSXljclMwOVRWMXRmWTJkcmg0dVBrNWVibjZPbnE4Zkx6OVBYMjkvajUrdi9FQUI4QkFBTUJBUUVCQVFFQkFRRUFBQUFBQUFBQkFnTUVCUVlIQ0FrS0MvL0VBTFVSQUFJQkFnUUVBd1FIQlFRRUFBRUNkd0FCQWdNUkJBVWhNUVlTUVZFSFlYRVRJaktCQ0JSQ2thR3h3UWtqTTFMd0ZXSnkwUW9XSkRUaEpmRVhHQmthSmljb0tTbzFOamM0T1RwRFJFVkdSMGhKU2xOVVZWWlhXRmxhWTJSbFptZG9hV3B6ZEhWMmQzaDVlb0tEaElXR2g0aUppcEtUbEpXV2w1aVptcUtqcEtXbXA2aXBxckt6dExXMnQ3aTV1c0xEeE1YR3g4akp5dExUMU5YVzE5aloydUxqNU9YbTUranA2dkx6OVBYMjkvajUrdi9hQUF3REFRQUNFUU1SQUQ4QTE1dkN1bTJ4QldPcTBtaldHN0t4MTFWL2JTT2ZrRllrOXRNcmZkTlpPYVRzVlpzcTI5bmJXN2doUlVzMkZSbXhnVXR4QTBNUWtmaXFWM2VwOWdjazR4VWUwdXJNcFJkN25iMzE3RmF2dGNnZldzUFVOV2hiYUVZWnoyckY4ZGZibnYxUzN6ZytsWmVtYUpmTnRlZVEvU3FsRnZRU2tremUxUzhWNEVVbnJYRStLYjBSV1cySi9yWFl6Nlc3QUJqa0FWNS80M3R4YlE0R2VhMFZLUExkN2srMGZOWTllMXRWTjJDUlZRU3JnQVZjMWovajVySFVuenFiM0paYmRpeTE1OThRWWk5cUd4MHIwQ1hpTVZ4dmp3RCt5eHhRNU5Ld0tLdmMvOWs9Ij4KCTwvaW1hZ2U+Cjwvc3ZnPg=="},"media_library_original":{"urls":["bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_960_1280.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_803_1071.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_672_896.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_562_749.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_470_627.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_393_524.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_329_439.jpg","bb46cc9f-2449-4bbc-ad22-0cba6de96d2f___media_library_original_275_367.jpg"],"base64svg":"data:image\\/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgOTYwIDEyODAiPgoJPGltYWdlIHdpZHRoPSI5NjAiIGhlaWdodD0iMTI4MCIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBK1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPREFwTENCa1pXWmhkV3gwSUhGMVlXeHBkSGtLLzlzQVF3QUlCZ1lIQmdVSUJ3Y0hDUWtJQ2d3VURRd0xDd3daRWhNUEZCMGFIeDRkR2h3Y0lDUXVKeUFpTENNY0hDZzNLU3d3TVRRME5COG5PVDA0TWp3dU16UXkvOXNBUXdFSkNRa01Dd3dZRFEwWU1pRWNJVEl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeS84QUFFUWdBS3dBZ0F3RWlBQUlSQVFNUkFmL0VBQjhBQUFFRkFRRUJBUUVCQUFBQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVFBQUlCQXdNQ0JBTUZCUVFFQUFBQmZRRUNBd0FFRVFVU0lURkJCaE5SWVFjaWNSUXlnWkdoQ0NOQ3NjRVZVdEh3SkROaWNvSUpDaFlYR0JrYUpTWW5LQ2txTkRVMk56ZzVPa05FUlVaSFNFbEtVMVJWVmxkWVdWcGpaR1ZtWjJocGFuTjBkWFozZUhsNmc0U0Zob2VJaVlxU2s1U1ZscGVZbVpxaW82U2xwcWVvcWFxeXM3UzF0cmU0dWJyQ3c4VEZ4c2ZJeWNyUzA5VFYxdGZZMmRyaDR1UGs1ZWJuNk9ucThmTHo5UFgyOS9qNSt2L0VBQjhCQUFNQkFRRUJBUUVCQVFFQUFBQUFBQUFCQWdNRUJRWUhDQWtLQy8vRUFMVVJBQUlCQWdRRUF3UUhCUVFFQUFFQ2R3QUJBZ01SQkFVaE1RWVNRVkVIWVhFVElqS0JDQlJDa2FHeHdRa2pNMUx3RldKeTBRb1dKRFRoSmZFWEdCa2FKaWNvS1NvMU5qYzRPVHBEUkVWR1IwaEpTbE5VVlZaWFdGbGFZMlJsWm1kb2FXcHpkSFYyZDNoNWVvS0RoSVdHaDRpSmlwS1RsSldXbDVpWm1xS2pwS1dtcDZpcHFyS3p0TFcydDdpNXVzTER4TVhHeDhqSnl0TFQxTlhXMTlqWjJ1TGo1T1htNStqcDZ2THo5UFgyOS9qNSt2L2FBQXdEQVFBQ0VRTVJBRDhBMTV2Q21tMnhCV09xMG1pMkJiSWpGZFZmMjBqbjVCV0xQYlRLMzNUV1RtazdGV2JLbHZaVzFzNElVVkxOdFZHYkdCUzNFRFF4Q1IrS3BYbDRuMkJpVGpGUjdSTldaU2k3M1IyOTlleFdyN1hZRDYxaDZocThMYlFqRFB0V0w0NiszdmZxbHZuQjlLeTlNMFMrYmEwOGhxcHhjdEFVb3BtOXFsNHJ3SXBOY1Q0cHZCRlo3WXBNZXRkalBwYnNBSE9RQlhuL0FJM3R4YlJBRFBOYUtsSGx1OXlQYVBtc2oxL1d3cHV3U0JWTVNyakFxNXJIL0h6V1FwUG5ZcHZjVExUc1dXdlAvaURFWHRWYkhTdlFKZUVGY1o0OEEvc3NjVU9UU3NKUjF1Zi8yUT09Ij4KCTwvaW1hZ2U+Cjwvc3ZnPg=="}}	1	2025-05-31 14:39:06	2025-06-06 00:04:07	\N
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_05_06_210722_create_permission_tables	1
5	2025_05_06_210723_add_two_factor_columns_to_users_table	1
6	2025_05_10_045214_create_cities_table	1
7	2025_05_10_091727_create_societies_table	1
8	2025_05_10_092039_create_sub_societies_table	1
9	2025_05_14_071102_create_media_table	1
10	2025_05_16_100903_create_sub_sectors_table	1
11	2025_05_16_122806_create_properties_table	1
12	2025_05_23_131947_create_personal_access_tokens_table	1
13	2025_06_09_121540_create_society_pages_table	2
14	2025_06_16_201646_create_projects_table	3
15	2025_06_18_170455_create_blogs_table	3
\.


--
-- Data for Name: model_has_permissions; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
\.


--
-- Data for Name: model_has_roles; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
1	App\\Models\\User	2
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
1	view users	web	2025-05-28 14:21:32	2025-05-28 14:21:32
2	create users	web	2025-05-28 14:21:32	2025-05-28 14:21:32
3	edit users	web	2025-05-28 14:21:32	2025-05-28 14:21:32
4	delete users	web	2025-05-28 14:21:32	2025-05-28 14:21:32
5	view cities	web	2025-05-28 14:21:32	2025-05-28 14:21:32
6	create cities	web	2025-05-28 14:21:32	2025-05-28 14:21:32
7	edit cities	web	2025-05-28 14:21:32	2025-05-28 14:21:32
8	delete cities	web	2025-05-28 14:21:32	2025-05-28 14:21:32
9	view societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
10	create societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
11	edit societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
12	delete societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
13	view sub_societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
14	create sub_societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
15	edit sub_societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
16	delete sub_societies	web	2025-05-28 14:21:32	2025-05-28 14:21:32
17	view sub_sectors	web	2025-05-28 14:21:32	2025-05-28 14:21:32
18	create sub_sectors	web	2025-05-28 14:21:32	2025-05-28 14:21:32
19	edit sub_sectors	web	2025-05-28 14:21:32	2025-05-28 14:21:32
20	delete sub_sectors	web	2025-05-28 14:21:32	2025-05-28 14:21:32
21	view properties	web	2025-05-28 14:21:32	2025-05-28 14:21:32
22	create properties	web	2025-05-28 14:21:32	2025-05-28 14:21:32
23	edit properties	web	2025-05-28 14:21:32	2025-05-28 14:21:32
24	delete properties	web	2025-05-28 14:21:32	2025-05-28 14:21:32
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: projects; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.projects (id, user_id, domain, title, slug, heading, meta_keywords, meta_description, description, longitude, latitude, created_at, updated_at, deleted_at) FROM stdin;
2	1	advice.pk	Orchard Farms	orchard-farms	Orchard Farms	\N	\N	\N	0	0	2025-06-22 20:31:44	2025-06-22 20:31:44	\N
\.


--
-- Data for Name: properties; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.properties (id, user_id, society_id, sub_sector_id, purpose, property_type, title, slug, description, keywords, plot_no, street, location, latitude, longitude, plot_size, plot_dimensions, price, rent, rent_type, features, nearby_facilities, installment_plan, best_selling, today_deal, approved, status, map_embed, video_embed, short_video_url, extra_data, created_by, views, created_at, updated_at, deleted_at) FROM stdin;
2	1	1	1	sale	plots	Bahria enclave islamabad 5 marla plot for sale.	bahria-enclave-islamabad-5-marla-plot-for-sale	excellent location. corner,parkface, possession charges paid . ready for construction.	bahria, enclave, islamabad, 5, marla, plot, for, sale., 	56	9	\N	0.00000000	0.00000000	5 Marla	\N	8700000	\N	\N	\N	\N	\N	t	f	t	active	\N	\N	\N	\N	\N	0	2025-05-31 13:55:47	2025-05-31 18:55:22	\N
3	1	1	6	sale	plots	b1 5 marla plot	b1-5-marla-plot	Lvel plot neaer to masjid school pump near to GHQ	b1, 5, marla, plot, 	564	23	\N	0.00000000	0.00000000	5 Marla	\N	6000000	\N	\N	\N	\N	\N	t	t	t	active	\N	\N	\N	\N	\N	0	2025-05-31 14:01:14	2025-05-31 18:55:22	\N
4	1	1	6	sale	homes	5 marla  house for rent	5-marla-house-for-rent	nAva ghar near to0 main motaerway	5, marla, , house, for, rent, 	\N	\N	\N	0.00000000	0.00000000	7 Marla	\N	70000000	\N	\N	\N	\N	\N	t	t	t	active	\N	\N	\N	\N	\N	0	2025-05-31 14:05:06	2025-05-31 18:55:22	\N
5	1	1	1	sale	apartments	2 bed appartment for sale in Bahria encalve	2-bed-appartment-for-sale-in-bahria-encalve	brand new near to school \r\nprime locatgion	2, bed, appartment, for, sale, in, bahria, encalve, 	\N	\N	\N	0.00000000	0.00000000	5 Marla	\N	8000000	\N	\N	\N	\N	\N	t	t	t	active	\N	\N	\N	\N	\N	0	2025-05-31 14:09:11	2025-05-31 18:55:22	\N
6	1	1	5	rent	homes	7 marla house for rent	7-marla-house-for-rent	near to schjoo,l near to muree	7, marla, house, for, rent, 	\N	\N	\N	100.00000000	100.00000000	7 Marla	\N	70000	70009	\N	\N	\N	\N	t	t	t	active	\N	\N	\N	\N	\N	0	2025-05-31 14:19:20	2025-05-31 18:55:22	\N
7	1	1	6	sale	shop	ground fllor front facing main road	ground-fllor-front-facing-main-road	main market shop wityh big barnds impressiave rent geantrating	ground, fllor, front, facing, main, road, 	\N	\N	\N	88.00000000	77.00000000	5 Marla	\N	1290000	\N	\N	\N	\N	\N	t	t	t	active	\N	\N	\N	\N	\N	0	2025-05-31 14:39:06	2025-05-31 18:55:22	\N
\.


--
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
1	1
2	1
3	1
4	1
5	1
6	1
7	1
8	1
9	1
10	1
11	1
12	1
13	1
14	1
15	1
16	1
17	1
18	1
19	1
20	1
21	1
22	1
23	1
24	1
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
1	admin	web	2025-05-28 14:21:32	2025-05-28 14:21:32
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
azzeyxbvVETSk86IZrHqDiZJmJwhRxlEwuBVtXhw	\N	34.223.48.121	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiVEhpTlBnMDMzTGlaRng1MHdrNjNxVWY5d3ZTUmwyOGJMekZiVEhOSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752220487
bWW6vJOTa50VVvQKjms82tsAZFNmlRA2p6KpeoYK	\N	157.119.40.23	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoialhYeUViT1NOdzdpS0JMTXZmY0N5Y1RTNkRWUVNUVENwNTNmeGphVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vYXV0b2NvbmZpZy5yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752241376
Fx6NAsCjykzMHI4GrwucwLKb8Ecnz4lNNqSFcf24	\N	64.227.98.72	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGg0TmJMeHhpQjZ5Zm5EWldkUWNXYlR4dExWRHRmV0VmOWVhZWMzWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9tYWlsLnJlYWxlc3RhdGVhaS5wayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1752282468
uOfseIJLtflRUagUsKbQgBqgfhLTRsOLDnTgWzSN	\N	35.93.166.213	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoib3hFbHBtQ0xBQzZXTThGZlRRaDF2eTIyakZEb2VseGthbTg2RXdKTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752371679
idyR8qxVFigIRcAVf9cLycBw0H3MQN1k8rPzaRT1	\N	34.217.71.208	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnkwazRrb3JoSm5JWWFTVDdvaFJrMk9HNHQ0NVlxaWdMSzVSWG0zOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752383526
XBEldEVuSS0T9TiTVdhKsaTwlp1ZQnZ4gmrhjeWN	\N	144.126.223.125	Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0	YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUdVRXBvVnQ1NEFWaEpzdTFmUTdrTGdHOVJiN3BUME91eFUzaDlWTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9hdXRvY29uZmlnLnJlYWxlc3RhdGVhaS5wayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1752220932
0V87rIZDX1Qcp79eYJpjkNcBVkuoYr7KTdS9ckmX	\N	20.171.207.173	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2RIMWdocTgxU0xJcWh4eWdISWo2T3l3dVJvVnpjMEJXTjcwSWZnSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vd3d3LnJlYWxlc3RhdGVhaS5way9hZG1pbi9zdWJzZWN0b3JzLyQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752246393
nMlOJ7e9t4g8y3EYHk2DVhAQ1sSVp9KwmgUwCMle	\N	64.227.98.72	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWcwT0JrWDhHMU81cXdWYU9qSWVyVkFOQnpkRWZKaFRsWkN6cUFpMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbWFpbC5yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752282469
bWJFripI80xa7JO5LJ9b5KxiDEHJVPL8Guja4fSn	\N	58.27.225.6	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDZJdkl4ZTVqSUxDVWNMMDFDVDExdWdNUlBMUHBOYUlWb2oxRFVrdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752216031
aLVZIXtDtHgTPRPfKm5DEk8jKJTzAn3xKbxXw5Yp	\N	34.210.70.39	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoicHgwbEpIMFVCY2oxSjc4NzdLeTV5QmZrcHdOaE91SnlTRVRUREF2TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752371808
kTOq987BUKCSR6vhAxPO2Zyelc3WK8umDqnlPv1L	\N	34.217.71.208	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoid3doZm9HdDRnYUVzZlpoT2ZGNHd1UXZ5ZDFwUjNjWkpzYmZXbnk5bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752383530
EpsnVERiCTnomkMI01YDh7Fg6Tihrd6Gybc6GHIQ	\N	144.126.223.125	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFVYUkJ1STNvbUZ5b3NFZHMzR0g0MUFJQVN2U1pwUEh6cjM0eUVlVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vYXV0b2NvbmZpZy5yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752220933
usLl2o5FLY5K0ipXn8bsJNc0XP8Srv7xythuUxZu	\N	20.171.207.148	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2N3UEJqQXdQWXFDeUtsMEF3UDQ2MUp3RFJldnVPTjJ3N2JUZ0g3MiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnJlYWxlc3RhdGVhaS5way9hZG1pbi9jaXRpZXMvOmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752248867
kbptnAXQh7p2FAB1ZRdsxdMU05PjKTuz827rxSgR	\N	3.80.59.153	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW1sRXBOU2lpUUdLc3p6TDdTcWxyclJ0NlRna0R6WkkwNXNBMUtVVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly93d3cucmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752294405
XOcAArfdpZASfunUUiYrfyoslFHAD4Lf0lYULGz5	\N	34.210.70.39	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUk5b0RUTnIyeU55MnJJeHhjRW5WUHQ2OXgxcjY4VGQ2Z2tMQlJBWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752371810
qKROPEjy1nAFGm1uZgrFdR9Ficmazk2cIgpxTsiP	\N	34.219.16.160	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGE0N2JrUTlvMzM4ZnlSV3Ryc0ZpVkkwZE5YV0NzN3JZSTUzRGNYRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752383551
z0Ryuo8aw59euSbZf7FSErGLGzdcPxZ41rSmrbUC	\N	44.252.114.76	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2hoWllpeGNEM201Y3VuNzB3WDBpOWZScTRHOFd2cGhWeFdzbGFJbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752220159
v8OyUs9kK6j4UptCCdgnsCMpJIXf5WH0x1Q4Re8h	\N	44.247.147.203	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG1sT1ZTTXRYNnVzdVc3ZUt6TTFmWFNmY0JUOFhjNjgyaTl6MFZ1WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752229382
Wi7uBAxLDwt4AeZ0DVDDqyAdXA6SIMU2c7iaf4BJ	\N	20.171.207.99	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoicUM0MEJOZVdLRERJNWpxdkRramtkdVlwVVBkNmt1enFpUFRIZGszeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752249185
PZObX1Ev2YIOvefO6vfuzCrb4N9e1DRZXkGbsTil	\N	54.160.142.104	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkd4aTdtcGlMcXJqa1NMN094M0lOMHpMaVlsMmZGc096VGE3TDcydCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752294596
GF6ixUcc5TSGdtzH983JiqWgyT4QbBlk43shacYG	\N	44.249.175.86	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTQ3Z3lvVjJUb0dNZVh6ZVVCZ1BNVlEyUjZFMzlpT3FnVnV0cjE3dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752371835
ubdRTEKeDtZtK5zDYnPHxmJFWbEkF0XQUZWmiUu8	\N	52.27.238.136	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoibHZyT3d3THo3aGhScGVKdTJQZ0hOZ1JRRkZaa1UzNmZycmo5S1ZCZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752383784
07KQDGvhntSWR2QBLQxPo5qQBrXIse3jQWG0tFpD	\N	44.252.114.76	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2VDN1ZvNkdpQm5CblYyMlJxMWhXMVNQRHVZQm81RWw4TXE5b2RZbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752220183
5K6QXSlJnLuH1mtbNjZ1Wy4errkOgN42yCndGUyX	\N	44.247.147.203	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoicE83OUVzRE1qS1I4ZU9zbFJhaXhmNmI5QUpFR0dJSUVrZFNXQWFERyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752229431
eh8rAJUkzeRso4vk9o1n2r3JCXF635HW0KM84WVN	\N	20.171.207.43	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTdwNGVYRkM2c1NONlYzVDVqMTMxTDRMem5FV1hWWk03RGpkdWV0WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vd3d3LnJlYWxlc3RhdGVhaS5way9hZG1pbi9jaXRpZXMvOmlkL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752251592
YpzWg2OMvGzriWZ71ae5JPX67tCP3o7QVlac8HVh	\N	138.197.45.196	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkZPcHB5V0RyeDNhRHdCM2I4RmpzcEhocHEzZVE5bnVLbHJYdnRYSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9tYWlsLnJlYWxlc3RhdGVhaS5wayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1752308175
mnWxYoS27tflU7IGozqNmgtZjDg4XUvxspTJlV1o	\N	34.217.206.34	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoibkx3U2Z6c2ZBamJIY0I3VGJTSjA0dVFZMXYxam5MUXRWd0NCTVRBRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752371987
Eno3Engb2f4fHrrkrIpHGJZGNHNgwmWsgMO2gmod	\N	52.27.238.136	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoidktpWEVKRjVwdEtKYThLZkNPTjJMYldvdVVPQmswSlR4Smxkdkc2TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752383786
dQJnmkJxR0WTpsAXjXe2jNjGWlZ2VCbBiuPhOGua	\N	54.186.1.71	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoidWx3SFFQaUV5N0FNWWJUbFdQaU9aVUJvTEc1OVhlcW5ZM1U5cURJRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752220288
BUd3F6osuzu5XjjIBJvy4jwuQcMnuSgbpSuYBjJO	\N	34.216.234.230	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUR0TDI4bkg4cEU3bndGNDQ3eXppRVNFR2UwRklhdUJ2MEdRR1huViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752229458
vQLIhU2FIJWXpZw6BNhUOujXrx1T77A3kztbsrHq	\N	20.171.207.43	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFZWVU9FSWZ1bG5SNk1rMnhZckxoUkxWRk5RdTRabjViSEU5dUh0QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vd3d3LnJlYWxlc3RhdGVhaS5way9hZG1pbi9zdWJzZWN0b3JzL19faWRfXy9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752253611
FwMDloHfDsMd75zgOTbGBOELa11ma3lrTxVYPz2Z	\N	138.197.45.196	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUw4enVvdFhGdGRNU1V1M2h1eFV1ekUzTzJ6dkhNZTVxVWpOQmhXQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbWFpbC5yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752308176
Wzip1CU9Dck7RsioMv1RqxTqM86lTLIs2qKiPnwF	\N	34.217.206.34	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiN01hbkU4aERaQXBHRk8zdVdENkhYVHpraXR6SXlDd0Q4MWo4NUZaTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752371988
MSGFbrvl0kUxRmMcPJIMWBjmJSyWVUfcSQdQEkX4	\N	34.222.208.92	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoicEF0WmpvclBEOXZTcDVwVXg1Q2ZTYVp5THNZano3YjZ6Vnk0Z0tlWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752383808
cW6RA9bymiAxLzXn7JJpw8hbVCfr0tWswaPnoCng	\N	54.186.1.71	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzV2NVJuTjdBYmJYZkl2Q0IxUVlLZUpySTlheThiMmxxdURYNnFHbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752220312
pl0AZl5ObU0P2Kg7uA9Ncuno68IOHVJsMihmaDki	\N	54.186.170.32	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVFSTDlNWTEzZ2dMY2RwVkhsZGlzeFFmSkRaUGNSSTJFbWN5MkNhViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752229565
6FY956Ate1ZUCrtZG0RjHDfw88UPtMF6Fia8G5i0	\N	20.171.207.43	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoib3RGU0dhbWFKWDBLb3hzRzVGRzRFemRtZ1hZblJGc3BNVDdnN1c2TCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vd3d3LnJlYWxlc3RhdGVhaS5way9hZG1pbi9zdWJzZWN0b3JzL19faWRfXyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1752255488
G7evqJ7tspjzKxjxpCToD6YcsO42IQEfgDPMvXKg	\N	153.92.14.40	Go-http-client/1.1	YToyOntzOjY6Il90b2tlbiI7czo0MDoibTJtbDNEWDJXQm5CNDBvVVNxWjFpSkZ0SHBoa0N0dnFBcDZqR2ppZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752364988
k6lkZKuMksqlQfyZbQ4HycK34SYQ7K6KF7khyOXh	\N	54.92.218.102	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjY4cjBVVFhxUXY5QW5ncUV1UFBVeHpJT0I3dUp4YzluMU5PeUVTSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly93d3cucmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752373908
1vfgEXW2NTMKQyD23JdrtgO8mcCVgROsOl5ZYmpe	\N	71.6.134.234	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoib2huVkhSd3F5UTJaYmkwN2RUNk1GR3R4azFEUWZmN2FYQlN2aXQ4biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vbWFpbC5yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752402817
fPGu93iCwdSna3aIIV2hNrkCeuSNYULbwVFlAdrP	\N	44.245.220.99	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFZTVjJBUElWcURWd2JRanVnTDVhQmJZZXFvTUR2WVByOVNlMUo3RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752220316
z4sEluJZIsu3PCN3JeBYKBt0yle4QaHSBU1A9NRs	\N	54.186.170.32	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDdyT3BldmtZWVNsRXZIVmJ1SEY5bTRYYVFndXY4S1JQWjJvZVFKNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752229568
VmwlGkzqAuOzuK6oY6MHfWTkwvs3GZQhXLbkQBVF	\N	20.171.207.43	Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)	YTozOntzOjY6Il90b2tlbiI7czo0MDoib3hKRzc1U3VhM0JUc3hDWDZabWhmdFBXZG1YREtxUWZPVUZBb2ptZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vd3d3LnJlYWxlc3RhdGVhaS5way9hZG1pbi9zdWJzZWN0b3JzL19faWRfXy9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752257396
EOVlMqx6A3U8O1nE5Wrco0HI0bQMpcTDYMaCBRRx	\N	34.210.70.39	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWJSWlA0VHM4TmZWcldBbDRuWkJvVzdDY1dGYkpxS2FmU0lLRnIxdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752371645
gKtLXhdtgICoEd353UWZYLcrfGVTZpv9OKzVtDLA	\N	52.87.221.33	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiUk1JczJBMExWV3pSUjhsWXlBWUgyYzRLVUNNZ0tWeGI5VzRtVW94RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752374221
sk1fxq6SkDXk0zTVjLsVrPlmq9eU0plCOYaW8UFc	\N	34.210.78.178	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoieDlqbWRRUnM0RFJtMVp0R1k2bWtoS21qTkdtSHFvY2cyVGtwekpORiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752220445
NlHb0xv8z7z3fcVunTBPG0518XZZ4kbMPMH4dJHh	\N	35.87.65.30	Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiSU9jb1FCbVNGcTZ0RzRsdzBYVTRjbzRxcmhZNHBMWklDeWV1SUlGUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752229603
fUQhsHB9YvVy0rpZma3vjnf2BKvnFUjKDfij3whY	\N	153.92.14.40	Go-http-client/1.1	YToyOntzOjY6Il90b2tlbiI7czo0MDoiZXNHWVQweXpVSTBpM2ozd1ZsMkJBTU1oUU1aZHZ1bFdsVkZKWnF6YiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752278556
tFYCB9ZunLt92iNyMWkcIGsT3ldB94rk4VJJLxa0	\N	34.210.70.39	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnRJQnBuQTA5QTNPeWZYQXVlVEdUbUNaeDZpdUpRTHVZenZXSEdGbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752371649
FkmsvR0VQPRGRMZUA9AwLQ8plSAz2lzhVH8oGkiz	\N	185.177.72.35	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3	YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHpPT1d1aHdMOFdmUVZyU0V0Tk11aHE2TnYyN2doTHZPdmVrTk5vbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9yZWFsZXN0YXRlYWkucGsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19	1752375292
9ikZUNAE5oBOhiLGkVH52RadozGpsMkpj5f27Pjr	\N	34.210.78.178	Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3FPYW81c3ZtcEo4eDV4cnR1Vm80VlVWbXRkb1hMZ2tnd3B4aElwNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vcmVhbGVzdGF0ZWFpLnBrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1752220448
\.


--
-- Data for Name: societies; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.societies (id, user_id, city_id, name, slug, meta_data, map_data, overview, detail, has_residential_plots, has_commercial_plots, has_houses, has_apartments, has_farm_houses, has_shop, property_types, created_by, status, created_at, updated_at, deleted_at) FROM stdin;
1	1	3	Bahria Enclave islamabad	bahria-enclave-islamabad	\N	\N	Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots	Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots. - Bahria Enclave Islamabad Possession is given now  and rapidly construction can be seen here.It is located approximately 8 km (10 minutes) drive from Chak Shahzad- Connecting Bahria Enclave to Park Road & the Kuri Road- Construction at full velocity of School, Mosque, Hospital, Commercial Mall, Restaurant, Park & Zoo-\r\n Features. 5 Star Hotel & Spa . Restaurants. Parks & Zoo. Cine Gold Plex Cinema. Commercial Areas. International Standard School & Hospital. Great Jamiah Mosque. 100 feet wide roads, landscaped with Green Belts & Footpaths. Complete Gated Community . Underground Provision of Electricity , 24 Hours security, supply of electricity , Gas,The layout plan was approved by Capital Development Authority. Bahria town your Life style Destination	t	t	t	t	t	t	{"residential_plots":{"title":"Bahria Enclave islamabad","keywords":"5 marla , 8 marla,10 marla ,1 kanal ,2 kanal.","description":"Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots."},"commercial_plots":{"title":"Bahria Enclave islamabad","keywords":"5 marla , 8 marla,10 marla ,1 kanal ,2 kanal .","description":"Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots."},"houses":{"title":"Bahria Enclave islamabad","keywords":"5 marla , 8 marla,10 marla ,1 kanal ,2 kanal.","description":"Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots."},"apartments":{"title":"Bahria Enclave islamabad","keywords":"5 marla , 8 marla,10 marla ,1 kanal ,2 kanal.","description":"Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots."},"farm_houses":{"title":"Bahria Enclave islamabad","keywords":"2 kanal, 4 kanal ,8 kanal","description":"Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots."},"shop":{"title":"Bahria Enclave islamabad","keywords":"5 marla , 8 marla,10 marla ,1 kanal ,2 kanal .","description":"Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots."}}	1	enabled	2025-05-31 12:58:02	2025-05-31 12:58:02	\N
2	1	3	Gulberg Islamabad	gulberg-islamabad	\N	\N	Gulberg Islamabad – A Blend of Luxury and Convenience\r\nGulberg Islamabad, developed by the Intelligence Bureau Employees Cooperative Housing Society (IBECHS), is a premier residential and commercial project in Pakistan’s capital. Strategically located on the Islamabad Expressway, it offers seamless connectivity to major parts of the city.	Gulberg Residencia\r\nGulberg Islamabad is envisioned in a way where nature's boundless beauty meets every luxury you’d expect. It is everything you have always dream of. Gulberg Islamabad is pleasantly located amidst the lush greenery of Islamaba	f	f	f	f	f	f	[]	1	enabled	2025-06-21 18:37:16	2025-06-21 18:37:16	\N
\.


--
-- Data for Name: society_pages; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.society_pages (id, user_id, slug, title, heading, detail, meta_keywords, meta_description, domain, created_at, updated_at, deleted_at) FROM stdin;
1	\N	defence-villas-islamabad	Defence Villas Islamabad	Defence Villas Islamabad	<p><strong style="background-color: rgb(255, 255, 255); color: rgb(51, 51, 51);">DEFENCE VILLAS ISLAMABAD</strong></p><p><span style="background-color: rgb(255, 255, 255); color: rgb(51, 51, 51);">Defence Villas is a new beginning in residential community. Proposed stylish villas are the continuity of DHA signature ‘DHA Homes’ concept in DHA Lahore. The residents of Defence Villas will have access to a world of international services, which are exclusive to DHA residents Defence Villas where every day dawn’s with promises is a relaxing and special journey into the ultimate residential lifestyle. A coveted new domain that offers you the incredible opportunity to live the lifestyle you’ve dreamed about for so many years. Each villa comes with imported fixtures and high class finishes. Defence Villas are designed to meet requirements of both small and large family sizes. Just 3 minute drive from GT Road Rawalpindi (near Toyota Rawal Motors) and access from Islamabad Highway, Defence Villas Phase 1, Sector-F is located on 210 ft wide Expressway. Its prime location makes it placed right opposite to the fully occupied Defence Housing Authority Sector E of Phase-1. Defence Villas is a completely secured gated community where amenities of life will be extended with international standards under a unique development plan along the picturesque bank of Soan River.</span></p>			realestateai.pk	2025-06-21 18:55:43	2025-06-21 18:55:43	\N
\.


--
-- Data for Name: sub_sectors; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.sub_sectors (id, society_id, parent_id, name, title, slug, meta_keywords, meta_detail, detail, block, created_at, updated_at, deleted_at) FROM stdin;
5	1	\N	B	b block bahria enclave	b	b block bahria enclave	b block bahria enclave	b block bahria enclave	Sector	2025-05-31 13:27:29	2025-05-31 13:27:29	\N
6	1	\N	B 1	bahria enclave b1	b-1	bahria enclave b1	bahria enclave b1	bahria enclave b1	Sector	2025-05-31 13:28:47	2025-05-31 13:28:47	\N
7	1	\N	B2	b2 bahria enclave islamabad	b2	b2 bahria enclave islamabad	b2 bahria enclave islamabad	b2 bahria enclave islamabad	Sector	2025-05-31 13:33:05	2025-05-31 13:33:05	\N
1	1	\N	A	A BLOCK BAHRIA ENCLAVE ISLAMABAD	a	a block bahria enclave islamabad	Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots.	Bahria Enclave Islamabad Is a Housing Project of Bahria Towns Exclusive community of 5, 8, 10 Marla & 1, 2, 4 Kanal residential plots & 4, 8 Marla commercial plots.	Sector	2025-05-31 12:58:02	2025-05-31 14:47:38	\N
8	2	\N	Gulberg Residencia	Gulberg Residencia	gulberg-residencia	Gulberg Residencia	Gulberg Residencia	\N	Block	2025-06-21 18:37:16	2025-06-21 18:37:16	\N
\.


--
-- Data for Name: sub_societies; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.sub_societies (id, society_id, name, slug, type, meta_keywords, meta_detail, detail, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: realestateai
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, deleted_at, two_factor_secret, two_factor_recovery_codes, two_factor_confirmed_at) FROM stdin;
1	Advice	salman@advice.pk	2025-05-28 14:21:32	$2y$12$VNsU.kFYF.IVWEFx3isSUunBQqi1NPTHexTrgp6KkJaFTKNilLS1W	XUepZ5vQdR	2025-05-28 14:21:32	2025-05-28 14:21:32	\N	\N	\N	\N
2	Admin User	admin@advice.pk	2025-05-28 14:21:32	$2y$12$jm8GunQrzYmR35zCYxD/yuV9pHcLVreRhK4MT7huxMSUHMATNm4JC	tfYlM9P8oZ	2025-05-28 14:21:32	2025-05-28 14:21:32	\N	\N	\N	\N
\.


--
-- Name: blogs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.blogs_id_seq', 1, false);


--
-- Name: cities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.cities_id_seq', 10, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.jobs_id_seq', 48, true);


--
-- Name: media_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.media_id_seq', 12, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.migrations_id_seq', 15, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.permissions_id_seq', 24, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: projects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.projects_id_seq', 2, true);


--
-- Name: properties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.properties_id_seq', 7, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.roles_id_seq', 1, true);


--
-- Name: societies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.societies_id_seq', 2, true);


--
-- Name: society_pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.society_pages_id_seq', 1, true);


--
-- Name: sub_sectors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.sub_sectors_id_seq', 8, true);


--
-- Name: sub_societies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.sub_societies_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: realestateai
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: blogs blogs_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.blogs
    ADD CONSTRAINT blogs_pkey PRIMARY KEY (id);


--
-- Name: blogs blogs_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.blogs
    ADD CONSTRAINT blogs_slug_unique UNIQUE (slug);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: cities cities_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.cities
    ADD CONSTRAINT cities_pkey PRIMARY KEY (id);


--
-- Name: cities cities_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.cities
    ADD CONSTRAINT cities_slug_unique UNIQUE (slug);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: media media_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_pkey PRIMARY KEY (id);


--
-- Name: media media_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_uuid_unique UNIQUE (uuid);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- Name: projects projects_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_slug_unique UNIQUE (slug);


--
-- Name: properties properties_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_pkey PRIMARY KEY (id);


--
-- Name: properties properties_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_slug_unique UNIQUE (slug);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: societies societies_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.societies
    ADD CONSTRAINT societies_pkey PRIMARY KEY (id);


--
-- Name: societies societies_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.societies
    ADD CONSTRAINT societies_slug_unique UNIQUE (slug);


--
-- Name: society_pages society_pages_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.society_pages
    ADD CONSTRAINT society_pages_pkey PRIMARY KEY (id);


--
-- Name: society_pages society_pages_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.society_pages
    ADD CONSTRAINT society_pages_slug_unique UNIQUE (slug);


--
-- Name: sub_sectors sub_sectors_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_sectors
    ADD CONSTRAINT sub_sectors_pkey PRIMARY KEY (id);


--
-- Name: sub_societies sub_societies_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_societies
    ADD CONSTRAINT sub_societies_pkey PRIMARY KEY (id);


--
-- Name: sub_societies sub_societies_slug_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_societies
    ADD CONSTRAINT sub_societies_slug_unique UNIQUE (slug);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cities_name_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX cities_name_index ON public.cities USING btree (name);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: media_model_type_model_id_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX media_model_type_model_id_index ON public.media USING btree (model_type, model_id);


--
-- Name: media_order_column_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX media_order_column_index ON public.media USING btree (order_column);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: projects_domain_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX projects_domain_index ON public.projects USING btree (domain);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: societies_name_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX societies_name_index ON public.societies USING btree (name);


--
-- Name: societies_status_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX societies_status_index ON public.societies USING btree (status);


--
-- Name: society_pages_domain_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX society_pages_domain_index ON public.society_pages USING btree (domain);


--
-- Name: sub_societies_name_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX sub_societies_name_index ON public.sub_societies USING btree (name);


--
-- Name: sub_societies_slug_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX sub_societies_slug_index ON public.sub_societies USING btree (slug);


--
-- Name: sub_societies_society_id_index; Type: INDEX; Schema: public; Owner: realestateai
--

CREATE INDEX sub_societies_society_id_index ON public.sub_societies USING btree (society_id);


--
-- Name: blogs blogs_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.blogs
    ADD CONSTRAINT blogs_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: projects projects_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: properties properties_society_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_society_id_foreign FOREIGN KEY (society_id) REFERENCES public.societies(id) ON DELETE CASCADE;


--
-- Name: properties properties_sub_sector_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_sub_sector_id_foreign FOREIGN KEY (sub_sector_id) REFERENCES public.sub_sectors(id) ON DELETE SET NULL;


--
-- Name: properties properties_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.properties
    ADD CONSTRAINT properties_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: societies societies_city_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.societies
    ADD CONSTRAINT societies_city_id_foreign FOREIGN KEY (city_id) REFERENCES public.cities(id) ON DELETE CASCADE;


--
-- Name: societies societies_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.societies
    ADD CONSTRAINT societies_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: society_pages society_pages_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.society_pages
    ADD CONSTRAINT society_pages_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: sub_sectors sub_sectors_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_sectors
    ADD CONSTRAINT sub_sectors_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.sub_sectors(id) ON DELETE CASCADE;


--
-- Name: sub_sectors sub_sectors_society_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_sectors
    ADD CONSTRAINT sub_sectors_society_id_foreign FOREIGN KEY (society_id) REFERENCES public.societies(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sub_societies sub_societies_society_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: realestateai
--

ALTER TABLE ONLY public.sub_societies
    ADD CONSTRAINT sub_societies_society_id_foreign FOREIGN KEY (society_id) REFERENCES public.societies(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

